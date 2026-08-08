<?php

namespace App\Services;

use App\Models\EarningWalletTransaction;
use App\Models\PackagePurchase;
use App\Models\User;
use App\Models\ZenithPoolLevelIncome;
use App\Models\ZenithPoolNode;

class ZenithPoolService
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

    public function enterPool(User $user, ?PackagePurchase $purchase = null): ZenithPoolNode
    {
        if ($existingNode = ZenithPoolNode::where('user_id', $user->id)->first()) {
            return $existingNode;
        }

        $root = $this->ensureRootUserNode();

        if ($root->user_id === $user->id) {
            return $root;
        }

        $parent = $this->findNextAvailableSlot($root);
        $position = $this->nextChildPosition($parent);

        $node = ZenithPoolNode::create([
            'user_id' => $user->id,
            'parent_id' => $parent->id,
            'position' => $position,
            'depth' => $parent->depth + 1,
            'package_purchase_id' => $purchase?->id,
            'joined_at' => now(),
        ]);

        $this->releaseCompletedLevelIncomes($node);

        return $node;
    }

    public function findNextAvailableSlot(?ZenithPoolNode $root = null): ZenithPoolNode
    {
        $root ??= $this->ensureRootUserNode();
        $queue = [$root->id];

        while (! empty($queue)) {
            $batchIds = $queue;
            $queue = [];

            $nodes = ZenithPoolNode::query()
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

                $childIds = ZenithPoolNode::query()
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

    private function ensureRootUserNode(): ZenithPoolNode
    {
        $rootUser = User::query()->orderBy('id')->lockForUpdate()->first();

        if (! $rootUser) {
            throw new \RuntimeException('Cannot start Zenith pool because no root user exists.');
        }

        return ZenithPoolNode::firstOrCreate(
            ['parent_id' => null],
            [
                'user_id' => $rootUser->id,
                'position' => 1,
                'depth' => 0,
                'joined_at' => now(),
            ]
        );
    }

    private function nextChildPosition(ZenithPoolNode $parent): int
    {
        $usedPositions = ZenithPoolNode::query()
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

        throw new \RuntimeException('Selected Zenith pool parent has no available child slot.');
    }

    private function releaseCompletedLevelIncomes(ZenithPoolNode $node): void
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

    private function releaseLevelIncomeIfComplete(ZenithPoolNode $node, int $level): void
    {
        if (ZenithPoolLevelIncome::where('zenith_pool_node_id', $node->id)->where('level', $level)->exists()) {
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

        $income = ZenithPoolLevelIncome::create([
            'zenith_pool_node_id' => $node->id,
            'user_id' => $node->user_id,
            'level' => $level,
            'slots_required' => $slotsRequired,
            'amount' => $amount,
            'paid_at' => now(),
        ]);

        $this->creditUserIncome($node, $income, $level, $amount);
    }

    public function filledSlotsAtLevel(ZenithPoolNode $node, int $level): int
    {
        $currentLevelIds = [$node->id];

        for ($currentLevel = 1; $currentLevel <= $level; $currentLevel++) {
            $currentLevelIds = ZenithPoolNode::query()
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

    private function creditUserIncome(ZenithPoolNode $node, ZenithPoolLevelIncome $income, int $level, float $amount): void
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
            'description' => 'Zenith Non-Working Global Pool Level '.$level.' complete income',
            'reference_no' => 'ZENITH-POOL-'.$income->id.'-U'.$receiver->id,
            'transaction_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
