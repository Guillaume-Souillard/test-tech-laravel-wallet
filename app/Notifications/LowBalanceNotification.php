<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowBalanceNotification extends Notification
{
    use Queueable;

    private int $balance;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $balance)
    {
        $this->balance = $balance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $balanceToDisplay = \Illuminate\Support\Number::currencyCents($this->balance);
        return (new MailMessage)
                    ->subject('Alerte : Solde faible sur votre compte')
                    ->greeting("Bonjour {$notifiable->name},")
                    ->line("Votre solde actuel est de **{$balanceToDisplay}**.")
                    ->line("Nous vous recommandons d'alimenter votre compte pour éviter tout désagrément.")
                    ->action('Voir mon compte', url(route('dashboard')))
                    ->line('Merci de votre confiance!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
