<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Mail\AlertMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AlertController;

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

                        $alertMessage = "✅ Payment Successful: We have automatically paid **{$expense->name}** for you this month. The amount of **{$expense->cost} DH** has been deducted from your budget. 💰";
                        $this->info("User {$user->id} paid for {$expense->name}");
                    } else {
                        \Log::warning("User {$user->id} does not have enough budget for {$expense->name}");

                        $alertMessage = "⚠️ Insufficient Funds: Your scheduled payment for **{$expense->name}** (**{$expense->cost} DH**) could not be processed due to insufficient funds in your budget. Please make the payment manually to avoid any service disruption. 🚨";
                    }

                    Mail::to($user->email)->send(new AlertMail($alertMessage));
                }
            }
            if (AlertController::budgetChecker($user)) {
                $totalExpenses = $user->total_expenses();
                $totalBudget = $user->budget + $totalExpenses;
                $percentageSpent = ($totalExpenses / $totalBudget) * 100;
                $alertMessage = "You've spent " . number_format($percentageSpent, 2) . "% of your budget. Please make sure your budget management is on track. We suggest using our AI for better management.";
                Mail::to($user->email)->send(new AlertMail($alertMessage));
            }
        }
    }
}
