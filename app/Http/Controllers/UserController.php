<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Provider\Time\FixedTimeProvider;

class UserController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $today = now();
        $lastDayOfMonth = Carbon::today('UTC')->endOfMonth();
        $daysLeft = floor($today->diffInDays($lastDayOfMonth));
        $categories = $user->expensesCategories->map(function ($category) {
            return $category->name;
        })->toArray();
        $categoryExpense = $user->expensesCategories->map(function ($category) {
            return $category->total_expenses;
        })->toArray();

        $expenses = $user->expenses;
        $recExpenses = $user->recExpenses;
        
        return view("client.index", [
            'user' => $user,
            'daysLeft' => $daysLeft,
            'categories' => $categories,
            'categoryExpense' => $categoryExpense,
            'expenses' => $expenses,
            'recExpenses' => $recExpenses,
        ]);
    }
}
