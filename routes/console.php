<?php

use App\Console\Commands\{CheckMonthlySalary, SetSavingGoalProgress, CheckRecExpenses};
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(SetSavingGoalProgress::class)->daily();
Schedule::command(CheckMonthlySalary::class)->daily();
Schedule::command(CheckRecExpenses::class)->daily();
