<?php

use App\Console\Commands\{CheckMonthlySalary, SetSavingGoalProgress};
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(CheckMonthlySalary::class)->daily();
Schedule::command(SetSavingGoalProgress::class)->daily();
