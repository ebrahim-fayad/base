<?php

use App\Console\Commands\DailyMacrosRewardCommand;
use App\Console\Commands\DailyPhysicalActivityCheckCommand;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(DailyMacrosRewardCommand::class)->dailyAt('23:59');
Schedule::command(DailyPhysicalActivityCheckCommand::class)->dailyAt('23:59');
