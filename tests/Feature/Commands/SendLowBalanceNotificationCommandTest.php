<?php

use App\Notifications\LowBalanceNotification;
use \Illuminate\Support\Facades\Notification;
use \App\Models\Wallet;
use \App\Models\User;

test('it sends low balance notifications to users with low balance', function () {
    Notification::fake();

    $userWithLowBalance = User::factory()->create();
    Wallet::factory()->create([
        'user_id' => $userWithLowBalance->id,
        'balance' => 5,
    ]);

    $userWithHighBalance = User::factory()->create();
    Wallet::factory()->create([
        'user_id' => $userWithHighBalance->id,
        'balance' => 10000000,
    ]);

    $this->artisan('app:send-low-balance-notification')->assertExitCode(0);

    Notification::assertSentTo($userWithLowBalance, LowBalanceNotification::class);
    Notification::assertNotSentTo($userWithHighBalance, LowBalanceNotification::class);
});
