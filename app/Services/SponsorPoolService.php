<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AdminEarningWalletTransaction;
use App\Models\EarningWalletTransaction;
use App\Models\PackagePurchase;
use App\Models\SponsorPoolLevelIncome;
use App\Models\SponsorPoolNode;
use App\Models\User;

class SponsorPoolService
{
    private const MAX_CHILDREN = 4;

    private const INCOME_BY_LEVEL = [
        1 => 500.0,
        2 => 1000.0,
        3 => 2000.0,
        4 => 4000.0,
        5 => 8000.0,
        6 => 16000.0,
    ];

    public function enterSponsorFromPurchase(User $purchaser, PackagePurchase $purchase): ?SponsorPoolNode
    {
        if ($existingNode = SponsorPoolNode::where('package_purchase_id', $purchase->id)->first()) {
            return $existingNode;
        }

        if (! $purchaser->sponsor_id) {
            return null;
        }

        $sponsor = User::where('member_id', $purchaser->sponsor_id)->first();

        if (! $sponsor) {
            return null;
        }

        return $this->enterPool($sponsor, $purchaser, $purchase);
    }

    public function enterPool(User $sponsor, User $purchaser, PackagePurchase $purchase): SponsorPoolNode
    {
        $root = $this->ensureAdminRootNode();
        $parent = $this->findNextAvailableSlot($root);
        $position = $this->nextChildPosition($parent);

        $node = SponsorPoolNode::create([
            'user_id' => $sponsor->id,
            'purchaser_id' => $purchaser->id,
            'parent_id' => $parent->id,
            'position' => $position,
            'depth' => $parent->depth + 1,
            'package_purchase_id' => $purchase->id,
            'joined_at' => now(),
        ]);

        $this->releaseCompletedLevelIncomes($node);

        return $node;
    }

    public function findNextAvailableSlot(?SponsorPoolNode $root = null): SponsorPoolNode
    {
        $root ??= $this->ensureAdminRootNode();
        $queue = [$root->id];

        while (! empty($queue)) {
            $batchIds = $queue;
            $queue = [];

            $nodes = SponsorPoolNode::query()
                ->whereIn('id', $batchIds)
                ->withCount('children')
                ->orderBy('depth')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            foreach ($nodes as $node) {
                if ($node->children_count < self::MAX_CHILDREN) {
                    return $node;
                }

                $childIds = SponsorPoolNode::query()
                    ->where('parent_id', $node->id)
                    ->orderBy('position')
                    ->orderBy('id')
                    ->pluck('id')
                    ->all();

                array_push($queue, ...$childIds);
            }
        }

        return $root;
    }

    private function ensureAdminRootNode(): SponsorPoolNode
    {
        $admin = Admin::orderBy('id')->first();

        if (! $admin) {
            throw new \RuntimeException('Cannot start Sponsor pool because no admin account exists.');
        }

        return SponsorPoolNode::firstOrCreate(
            ['admin_id' => $admin->id, 'parent_id' => null],
            [
                'position' => 1,
                'depth' => 0,
                'joined_at' => now(),
            ]
        );
    }

    private function nextChildPosition(SponsorPoolNode $parent): int
    {
        $usedPositions = SponsorPoolNode::query()
            ->where('parent_id', $parent->id)
            ->lockForUpdate()
            ->pluck('position')
            ->map(fn ($position) => (int) $position)
            ->all();

        for ($position = 1; $position <= self::MAX_CHILDREN; $position++) {
            if (! in_array($position, $usedPositions, true)) {
                return $position;
            }
        }

        throw new \RuntimeException('Selected Sponsor pool parent has no available child slot.');
    }

    private function releaseCompletedLevelIncomes(SponsorPoolNode $node): void
    {
        $ancestor = $node->parent;

        while ($ancestor) {
            $level = $node->depth - $ancestor->depth;

            if ($level >= 1 && $level <= 6) {
                $this->releaseLevelIncomeIfComplete($ancestor, $level);
            }

            $ancestor = $ancestor->parent;
        }
    }

    private function releaseLevelIncomeIfComplete(SponsorPoolNode $node, int $level): void
    {
        if (SponsorPoolLevelIncome::where('sponsor_pool_node_id', $node->id)->where('level', $level)->exists()) {
            return;
        }

        $slotsRequired = self::MAX_CHILDREN ** $level;

        if ($this->filledSlotsAtLevel($node, $level) < $slotsRequired) {
            return;
        }

        $amount = self::INCOME_BY_LEVEL[$level] ?? 0;

        if ($amount <= 0) {
            return;
        }

        $income = SponsorPoolLevelIncome::create([
            'sponsor_pool_node_id' => $node->id,
            'user_id' => $node->user_id,
            'admin_id' => $node->admin_id,
            'level' => $level,
            'slots_required' => $slotsRequired,
            'amount' => $amount,
            'paid_at' => now(),
        ]);

        $node->admin_id
            ? $this->creditAdminIncome($node, $income, $level, $amount)
            : $this->creditUserIncome($node, $income, $level, $amount);
    }

    public function filledSlotsAtLevel(SponsorPoolNode $node, int $level): int
    {
        $currentLevelIds = [$node->id];

        for ($currentLevel = 1; $currentLevel <= $level; $currentLevel++) {
            $currentLevelIds = SponsorPoolNode::query()
                ->whereIn('parent_id', $currentLevelIds)
                ->orderBy('position')
                ->orderBy('id')
                ->pluck('id')
                ->all();

            if (empty($currentLevelIds)) {
                return 0;
            }
        }

        return count($currentLevelIds);
    }

    private function creditUserIncome(SponsorPoolNode $node, SponsorPoolLevelIncome $income, int $level, float $amount): void
    {
        if (! $node->user_id) {
            return;
        }

        $receiver = User::lockForUpdate()->find($node->user_id);

        if (! $receiver) {
            return;
        }

        $openingBalance = (float) ($receiver->earning_wallet ?? 0);
        $closingBalance = $openingBalance + $amount;

        $receiver->update([
            'earning_wallet' => $closingBalance,
        ]);

        EarningWalletTransaction::create([
            'user_id' => $receiver->id,
            'type' => 'Credit',
            'amount' => $amount,
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'description' => 'Sponsor Global Pool Level '.$level.' complete income',
            'reference_no' => 'SPONSOR-POOL-'.$income->id.'-U'.$receiver->id,
            'transaction_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function creditAdminIncome(SponsorPoolNode $node, SponsorPoolLevelIncome $income, int $level, float $amount): void
    {
        if (! $node->admin_id) {
            return;
        }

        $receiver = Admin::lockForUpdate()->find($node->admin_id);

        if (! $receiver) {
            return;
        }

        $openingBalance = (float) ($receiver->earning_wallet ?? 0);
        $closingBalance = $openingBalance + $amount;

        $receiver->update([
            'earning_wallet' => $closingBalance,
        ]);

        AdminEarningWalletTransaction::create([
            'admin_id' => $receiver->id,
            'type' => 'Credit',
            'amount' => $amount,
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'description' => 'Sponsor Global Pool Level '.$level.' complete income',
            'reference_no' => 'SPONSOR-POOL-'.$income->id.'-A'.$receiver->id,
            'transaction_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
