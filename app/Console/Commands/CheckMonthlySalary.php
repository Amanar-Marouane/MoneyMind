<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Mail\AlertMail;
use Illuminate\Support\Facades\Mail;

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

                if ($user->credit_date == $currentDay || ($currentDay == 28 && $currentMonth == 2)) {
                    $user->budget += $user->salary;
                    $user->save();

                    $this->info("✅ Salary Added: A payment of {$user->salary} DH has been successfully added to the budget for user ID: {$user->id}.");

                    $alertMessage = "💰 **Salary Deposited** Good news! Your salary of **{$user->salary} DH** has been successfully added to your budget. You can now manage your expenses more efficiently. 🎉";
                    Mail::to($user->email)->send(new AlertMail($alertMessage));
                } else {
                    $this->info("Not today for user ID: {$user->id}. No salary processed.");
                }
            }
        }
    }
}
