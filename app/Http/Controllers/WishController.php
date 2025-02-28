<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WishController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $wishes = $user->wishes;
        return view('wishes.index', [
            'user' => $user,
            'wishes' => $wishes,
        ]);
    }
}
