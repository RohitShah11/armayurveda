<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\DirectTreeNode;
use App\Models\PackagePurchase;
use App\Models\User;

class DirectTreeService
{
    public function enterFromPurchase(User $user, PackagePurchase $purchase): DirectTreeNode
    {
        if ($existingNode = DirectTreeNode::where('user_id', $user->id)->first()) {
            return $existingNode;
        }

        $root = $this->ensureAdminRootNode();
        $parent = $this->findSponsorNode($user) ?: $root;
        $position = $this->nextChildPosition($parent);

        return DirectTreeNode::create([
            'user_id' => $user->id,
            'parent_id' => $parent->id,
            'position' => $position,
            'depth' => $parent->depth + 1,
            'package_purchase_id' => $purchase->id,
            'joined_at' => now(),
        ]);
    }

    private function ensureAdminRootNode(): DirectTreeNode
    {
        $admin = Admin::orderBy('id')->first();

        if (! $admin) {
            throw new \RuntimeException('Cannot start Direct tree because no admin account exists.');
        }

        return DirectTreeNode::firstOrCreate(
            ['admin_id' => $admin->id, 'parent_id' => null],
            [
                'position' => 1,
                'depth' => 0,
                'joined_at' => now(),
            ]
        );
    }

    private function findSponsorNode(User $user): ?DirectTreeNode
    {
        if (! $user->sponsor_id) {
            return null;
        }

        $sponsor = User::where('member_id', $user->sponsor_id)->first();

        if (! $sponsor) {
            return null;
        }

        return DirectTreeNode::where('user_id', $sponsor->id)->first();
    }

    private function nextChildPosition(DirectTreeNode $parent): int
    {
        $lastPosition = (int) DirectTreeNode::query()
            ->where('parent_id', $parent->id)
            ->lockForUpdate()
            ->max('position');

        return $lastPosition + 1;
    }
}
