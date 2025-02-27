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

        return redirect(route("dashboard"))->with("success", "Expense counted successfully");
    }
}
