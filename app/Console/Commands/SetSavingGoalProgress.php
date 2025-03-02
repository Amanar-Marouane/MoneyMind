<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertMail;

class SetSavingGoalProgress extends Command
{
    protected $signature = 'saving:progress';
    protected $description = 'Check if saving goal progress should be updated to the users.';

    public function handle()
    {
        \Log::info('Cron job executed at ' . now());

        foreach (User::where('role', 'Client')->get() as $user) {
            $currentDay = Carbon::now()->day;
            $currentMonth = Carbon::now()->month;

            if ($user->credit_date == $currentDay || ($currentDay == 28 && $currentMonth == 2)) {
                if ($user->budget > 0) {
                    $savedAmount = $user->budget;
                    $user->saving_goal_progress += $savedAmount;
                    $user->budget = 0;
                    $user->save();

                    $message = "💰 Your saving goal has been updated! We have transferred **$savedAmount DH** from your budget to your savings.";
                    Mail::to($user->email)->send(new AlertMail($message));

                    $this->info("Saving Goal of {$savedAmount} DH has been added for user ID: {$user->id}.");
                }
            } else {
                $this->info("Not today for user ID: {$user->id}. No Saving Goal processed.");
            }
        }
    }
}
