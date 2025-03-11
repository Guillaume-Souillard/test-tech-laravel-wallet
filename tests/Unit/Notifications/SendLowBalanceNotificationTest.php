<?php

declare(strict_types=1);

use App\Notifications\LowBalanceNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

test('it builds the correct email message', function () {
    $notification = new LowBalanceNotification(850);
    $notifiable = \App\Models\User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $mailMessage = $notification->toMail($notifiable);

    $this->assertInstanceOf(\Illuminate\Notifications\Messages\MailMessage::class, $mailMessage);
    $this->assertEquals('Alerte : Solde faible sur votre compte', $mailMessage->subject);
    $this->assertStringContainsString('Bonjour Test User,', $mailMessage->greeting);
    $this->assertStringContainsString('Votre solde actuel est de **€8.50**.', $mailMessage->introLines[0]);
    $this->assertStringContainsString('Nous vous recommandons d\'alimenter votre compte', $mailMessage->introLines[1]);
});
