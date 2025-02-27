<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;

class CheckRecExpenses extends Command
{
    protected $signature = 'rec:expenses';
    protected $description = 'Deduct recurring expenses from users with active budgets based on their scheduled dates.';

    public function handle()
    {
        \Log::info('Cron job executed at ' . now());

        $currentDay = Carbon::now()->day;
        $users = User::where('role', 'Client')->with('recExpenses')->get();

        foreach ($users as $user) {
            foreach ($user->recExpenses as $expense) {
                $starting_date = Carbon::parse($expense->starting_date);

                if ($starting_date->lt(now()) || $starting_date->day == $currentDay) {
                    if ($user->budget >= $expense->cost) {
                        $user->budget -= $expense->cost;
                        $user->save();
                        $this->info("User $user->id Paid $expense->name");
                    } else {
                        \Log::warning("User $user->id does not have enough budget for $expense->name");
                    }
                }
            }
        }
    }
}
