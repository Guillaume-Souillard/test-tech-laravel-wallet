<?php

declare(strict_types=1);

use App\Console\Commands\SendLowBalanceNotification;
use \Illuminate\Support\Facades\Schedule;

Schedule::call(SendLowBalanceNotification::class)->everyFiveMinutes();
