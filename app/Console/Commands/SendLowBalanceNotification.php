<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\LowBalanceNotification;
use Illuminate\Console\Command;

class SendLowBalanceNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-low-balance-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::query()
            ->whereHas('wallet', function($query) {
                $query->where('balance', '<', 10);
            })
            ->get();

        foreach ($users as $user) {
            $user->notify(new LowBalanceNotification($user->wallet->balance));
        }
    }
}
