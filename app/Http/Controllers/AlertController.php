<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class AlertController extends Controller
{
    public static function budgetChecker(User $user)
    {
        return $user->budget <= $user->total_expenses();
    }
}
