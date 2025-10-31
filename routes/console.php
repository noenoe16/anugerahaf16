<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Laravel 12 auto-discovers commands in app/Console/Commands

// Example: schedule CCTV ping status every minute
// You can add this to a cron via `php artisan schedule:run` per minute
// For route-based scheduler, you can also call this via Task Scheduler in Windows
