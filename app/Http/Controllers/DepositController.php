<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        return view('deposits.index', [
            'user' => $user,
        ]);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'value' => 'required|integer|min:0',
        ]);
        $validateData['user_id'] = Auth::id();
        Deposit::create($validateData);
        $user = User::find(Auth::id());
        $user->budget += $validateData['value'];
        $user->save();
        return redirect()->back()->with('success', 'Deposit Has Been Done Successfuly');
    }
}
