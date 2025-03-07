<?php

namespace App\Http\Controllers;

use App\Models\{User, Wish};
use App\Services\GeminiService;
use Illuminate\Support\Facades\Auth;

class tipController
{
    public function get()
    {
        $user = User::find(Auth::id());
        $expenses = $user->expenses;
        $recExpenses = $user->recExpenses;
        $wishes = $user->wishes;
        $tip = (new GeminiService)->generateTips([
            'expenses' => $expenses,
            'recurringExpenses' => $recExpenses,
            'wishes' => $wishes,
        ]);

        echo json_encode($tip, true);
    }
}
