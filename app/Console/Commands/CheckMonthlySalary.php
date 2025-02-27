<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;

class CheckMonthlySalary extends Command
{
    protected $signature = 'salary:check';
    protected $description = 'Check if monthly salary should be added to user\'s budget.';

    public function handle()
    {
        \Log::info('Cron job executed at ' . now());

        foreach (User::all() as $user) {
            if ($user->role == "Client") {
                $currentDay = Carbon::now()->day;
                $currentMonth = Carbon::now()->month;

                if ($user->credit_date == $currentDay || ($user->credit_date == 28 && $currentMonth == 2)) {
                    $user->budget += $user->salary;
                    $user->save();

                    $this->info("Payment of {$user->salary}dh has been added to your budget for user ID: {$user->id}.");
                } else {
                    $this->info("Not today for user ID: {$user->id}. No salary processed.");
                }
            }
        }
    }
}
