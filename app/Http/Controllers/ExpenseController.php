<?php

namespace App\Http\Controllers;

use App\Models\{Category, User, Expense};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ExpenseController extends Controller
{
    public function addView()
    {
        $categories = Category::all();
        return view("expense.add", compact("categories"));
    }

    public function add(Request $request)
    {
        $rules = [
            "name" => "required|string",
            "cost" => "required|integer|min:1",
            "category_id" => "required|string|exists:categories,id",
            "monthly" => "required|in:true,false",
        ];
        if ($request->monthly == "true") {
            $rules['starting_date'] = "required|date";
        }
        $validateData = $request->validate($rules);
        $validateData['monthly'] = $request->monthly === "true" ? true : false;
        $validateData['user_id'] = Auth::id();
        Expense::create($validateData);

        $user = User::find(Auth::id());
        if ($request->monthly == "false") {
            $user->budget -= (int) $request->cost;
            $user->save();
        } else {
            $date = Carbon::parse($request->starting_date);
            $current_day = Carbon::now()->day;
            $current_month = Carbon::now()->month;
            if ($date->day == $current_day && $date->month == $current_month) {
                $user->budget -= (int) $request->cost;
                $user->save();
            }
        }
        if (AlertController::budgetChecker($user)) {
            $totalExpenses = $user->total_expenses();
            $totalBudget = $user->budget + $totalExpenses;
            $percentageSpent = ($totalExpenses / $totalBudget) * 100;
            $alertMessage = "You've spent " . number_format($percentageSpent, 2) . "% of your budget. Please make sure your budget management is on track. We suggest using our AI for better management.";
        }

        return redirect(route("dashboard"))
            ->with("success", "Expense counted successfully")
            ->with("alertMessage", $alertMessage ?? false);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $expense = Expense::find($id);
        if (!$expense) {
            return redirect()->back()->with('error', 'Expense not found.');
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Recurring Expense Has Been Deleted');
    }
}
