<?php

namespace App\Services;

use App\Models\DirectTreeNode;
use App\Models\EarningWalletTransaction;
use App\Models\PackagePurchase;
use App\Models\User;
use App\Models\UserRankReward;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RankRewardService
{
    public const MAX_LEVELS = 15;

    public function ranks(): array
    {
        return [
            1 => ['name' => 'Pearl Wellness Leader', 'business' => 30000.0, 'reward' => 1000.0, 'additional' => 'Cash'],
            2 => ['name' => 'Bronze Herbal Leader', 'business' => 100000.0, 'reward' => 3000.0, 'additional' => 'Cash'],
            3 => ['name' => 'Silver Wellness Leader', 'business' => 300000.0, 'reward' => 8000.0, 'additional' => 'Cash'],
            4 => ['name' => 'Gold Wellness Leader', 'business' => 600000.0, 'reward' => 12000.0, 'additional' => 'Smartwatch'],
            5 => ['name' => 'Ruby Achiever', 'business' => 1000000.0, 'reward' => 18000.0, 'additional' => 'Mobile'],
            6 => ['name' => 'Platinum Achiever', 'business' => 2000000.0, 'reward' => 35000.0, 'additional' => 'Domestic Trip'],
            7 => ['name' => 'Diamond Director', 'business' => 4000000.0, 'reward' => 60000.0, 'additional' => 'Laptop'],
            8 => ['name' => 'Royal Ambassador', 'business' => 7000000.0, 'reward' => 100000.0, 'additional' => 'Bike'],
            9 => ['name' => 'Crown Ambassador', 'business' => 15000000.0, 'reward' => 300000.0, 'additional' => 'Royalty Pool Entry'],
        ];
    }

    public function processFromPurchase(User $buyer, PackagePurchase $purchase): void
    {
        if (! $this->isRankPackage($purchase)) {
            return;
        }

        $buyerNode = DirectTreeNode::where('user_id', $buyer->id)->first();

        if (! $buyerNode) {
            return;
        }

        $this->evaluateUser($buyer);

        $parentId = $buyerNode->parent_id;
        $level = 1;

        while ($parentId && $level <= self::MAX_LEVELS) {
            $parentNode = DirectTreeNode::with('user')->find($parentId);

            if (! $parentNode) {
                break;
            }

            if ($parentNode->user) {
                $this->evaluateUser($parentNode->user);
            }

            $parentId = $parentNode->parent_id;
            $level++;
        }
    }

    public function evaluateUser(User $user): Collection
    {
        return DB::transaction(function () use ($user) {
            $lockedUser = User::whereKey($user->id)->lockForUpdate()->first();

            if (! $lockedUser) {
                return collect();
            }

            $qualifiedBusiness = $this->teamBusiness($lockedUser);
            $newRewards = collect();

            foreach ($this->qualifiedRanks($qualifiedBusiness) as $rank => $config) {
                $alreadyPaid = UserRankReward::where('user_id', $lockedUser->id)
                    ->where('rank', $rank)
                    ->exists();

                if ($alreadyPaid) {
                    continue;
                }

                $openingBalance = (float) ($lockedUser->earning_wallet ?? 0);
                $rewardAmount = (float) $config['reward'];
                $closingBalance = $openingBalance + $rewardAmount;

                $lockedUser->update(['earning_wallet' => $closingBalance]);

                $transaction = EarningWalletTransaction::create([
                    'user_id' => $lockedUser->id,
                    'type' => 'Credit',
                    'amount' => $rewardAmount,
                    'opening_balance' => $openingBalance,
                    'closing_balance' => $closingBalance,
                    'description' => 'Rank Reward: '.$config['name'],
                    'reference_no' => 'RANK-'.$rank.'-'.$lockedUser->id.'-'.now()->timestamp,
                    'transaction_date' => now(),
                ]);

                $newRewards->push(UserRankReward::create([
                    'user_id' => $lockedUser->id,
                    'earning_wallet_transaction_id' => $transaction->id,
                    'rank' => $rank,
                    'rank_name' => $config['name'],
                    'required_business' => $config['business'],
                    'qualified_business' => $qualifiedBusiness,
                    'reward_amount' => $rewardAmount,
                    'additional_reward' => $config['additional'],
                    'status' => 'Paid',
                    'qualified_at' => now(),
                ]));

                $lockedUser->refresh();
            }

            return $newRewards;
        });
    }

    public function currentRank(User $user): ?UserRankReward
    {
        return UserRankReward::where('user_id', $user->id)
            ->orderByDesc('rank')
            ->first();
    }

    public function nextRank(User $user): ?array
    {
        $currentRank = (int) (UserRankReward::where('user_id', $user->id)->max('rank') ?? 0);

        return $this->ranks()[$currentRank + 1] ?? null;
    }

    public function teamBusiness(User $user): float
    {
        $node = DirectTreeNode::where('user_id', $user->id)->first();

        if (! $node) {
            return 0.0;
        }

        $userIds = $this->downlineUserIds($node);

        if ($userIds->isEmpty()) {
            return 0.0;
        }

        return (float) PackagePurchase::query()
            ->whereIn('user_id', $userIds)
            ->where('status', 'Completed')
            ->whereHas('package', function ($query) {
                $query->whereIn(DB::raw('lower(category)'), ['basic', 'zenith']);
            })
            ->sum('package_price');
    }

    public function progressFor(User $user): array
    {
        $business = $this->teamBusiness($user);
        $currentRank = $this->currentRank($user);
        $nextRank = $this->nextRank($user);

        return [
            'business' => $business,
            'current_rank' => $currentRank,
            'next_rank' => $nextRank,
            'remaining' => $nextRank ? max(0, (float) $nextRank['business'] - $business) : 0,
        ];
    }

    private function qualifiedRanks(float $business): array
    {
        return array_filter(
            $this->ranks(),
            fn (array $rank) => $business >= (float) $rank['business']
        );
    }

    private function downlineUserIds(DirectTreeNode $node): Collection
    {
        $userIds = collect();
        $parentIds = collect([$node->id]);

        for ($level = 1; $level <= self::MAX_LEVELS && $parentIds->isNotEmpty(); $level++) {
            $children = DirectTreeNode::query()
                ->whereIn('parent_id', $parentIds)
                ->get(['id', 'user_id']);

            $userIds = $userIds->merge($children->pluck('user_id')->filter());
            $parentIds = $children->pluck('id');
        }

        return $userIds->unique()->values();
    }

    private function isRankPackage(PackagePurchase $purchase): bool
    {
        $purchase->loadMissing('package');

        return $purchase->status === 'Completed'
            && in_array(strtolower($purchase->package?->category ?? ''), ['basic', 'zenith'], true);
    }
}
