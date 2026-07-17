<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Services\RankRewardService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('rank-rewards:process {member_id?}', function (?string $member_id = null) {
    $service = app(RankRewardService::class);

    $users = User::query()
        ->when($member_id, fn ($query) => $query->where('member_id', $member_id))
        ->orderBy('id')
        ->get();

    if ($users->isEmpty()) {
        $this->warn('No members found for rank reward processing.');

        return 0;
    }

    $created = 0;

    foreach ($users as $user) {
        $created += $service->evaluateUser($user)->count();
    }

    $this->info("Rank reward processing completed. New rewards paid: {$created}.");

    return 0;
})->purpose('Process rank rewards for all members or one member ID');
