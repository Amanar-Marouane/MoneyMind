<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;

class SetSavingGoalProgress extends Command
{
    protected $signature = 'saving:progress';
    protected $description = 'Check if saving goal progress should be updated to the users.';

    public function handle()
    {
        \Log::info('Cron job executed at ' . now());

        foreach (User::all() as $user) {
            if ($user->role == "Client") {
                $currentDay = Carbon::now()->day;
                $currentMonth = Carbon::now()->month;

                if ($user->credit_date == $currentDay || ($currentDay == 28 && $currentMonth == 2)) {
                    $user->saving_goal_progress = $user->budget;
                    $user->budget = 0;
                    $user->save();

                    $this->info("Saving Goal of {$user->budget}dh has been added to your saving goal progress for user ID: {$user->id}.");
                } else {
                    $this->info("Not today for user ID: {$user->id}. No Saving Goal processed.");
                }
            }
        }
    }
}
