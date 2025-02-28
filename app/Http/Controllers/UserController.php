<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Support\Carbon;

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

    public function adminIndex()
    {
        $active_count = count(User::where(DB::raw('DATEDIFF(CURRENT_TIMESTAMP, loged_in_at)'), '<=', 60)->get());
        $inactif_count = count(User::all()) - $active_count;
        $avg_expenses_value = number_format(
            Expense::where('created_at', '>=', Carbon::now()->subDays(30))->avg('cost'),
            2
        );
        $users = User::all();
        $monthlyUsers = array_fill(0, 12, 0);

        foreach ($users as $user) {
            $monthIndex = Carbon::parse($user->created_at)->month - 1;
            $monthlyUsers[$monthIndex]++;
        }

        $categories = Category::with('expenses')->get();
        $categoriesExpenses = [];
        foreach ($categories as $category) {
            $total = $category->expenses->sum('cost');
            $categoriesExpenses[] = $total;
        }
        $categoryNames = $categories->pluck('name')->toArray();

        return view('admin.index', [
            'active_count' => $active_count,
            'inactif_count' => $inactif_count,
            'avg_expenses_value' => $avg_expenses_value,
            'monthlyUsers' => $monthlyUsers,
            'categoriesExpenses' => $categoriesExpenses,
            'categoryNames' => $categoryNames,
        ]);
    }
}
