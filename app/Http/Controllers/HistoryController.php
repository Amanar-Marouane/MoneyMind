<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Expense, History};
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('monthly', false)
            ->get();
        $history = History::all();

        $combined = $expenses->merge($history);

        $groupedByMonth = $combined->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('m-Y');
        });

        $sorted = $groupedByMonth->sortByDesc(function ($group) {
            return $group->first()->created_at;
        })->first();

        $currentYearExpenses = $combined->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y');
        })->last();

        $monthlySums = $currentYearExpenses->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        })->mapWithKeys(function ($group, $key) {
            $monthName = Carbon::parse($key)->format('F');
            return [$monthName => $group->sum('value') + $group->sum('cost')];
        });

        return view('history.index', [
            'histories' => $sorted,
            'months' => $monthlySums->keys(),
            'values' => $monthlySums->values(),
        ]);
    }
}
