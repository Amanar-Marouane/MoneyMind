<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Expense, History, User};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $expenses = $user->expenses;
        $history = $user->history;

        $combined = $expenses->merge($history);

        if (!$combined->isEmpty()) {
            $groupedByMonth = $combined->groupBy(function ($item) {
                return $item->created_at ? Carbon::parse($item->created_at)->format('m-Y') : null;
            });

            $sorted = $groupedByMonth->sortByDesc(function ($group) {
                return $group->first() ? $group->first()->created_at : now();
            })->first();

            $currentYearExpenses = $combined->groupBy(function ($item) {
                return $item->created_at ? Carbon::parse($item->created_at)->format('Y') : null;
            })->last();

            $monthlySums = $currentYearExpenses->groupBy(function ($item) {
                return $item->created_at ? Carbon::parse($item->created_at)->format('Y-m') : null;
            })->mapWithKeys(function ($group, $key) {
                $monthName = $key ? Carbon::parse($key)->format('F') : 'Unknown Month';
                return [$monthName => ($group->sum('value') ?? 0) + ($group->sum('cost') ?? 0)];
            });
        } else {
            $sorted = collect();
            $monthlySums = collect();
        }

        return view('history.index', [
            'histories' => $sorted,
            'months' => $monthlySums->keys(),
            'values' => $monthlySums->values(),
        ]);
    }
}
