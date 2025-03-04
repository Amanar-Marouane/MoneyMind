<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Expense, History};

class HistoryController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('monthly', false)->get();
        $history = History::all();

        $combined = $expenses->merge($history);

        $sorted = $combined->sortByDesc('created_at');

        return view('history.index', [
            'histories' => $sorted,
        ]);
    }
}
