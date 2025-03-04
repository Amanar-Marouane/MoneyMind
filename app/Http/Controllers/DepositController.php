<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::all();
        return view('deposits.index', [
            'deposits' => $deposits,
        ]);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'value' => 'required|integer|min:0',
        ]);
        Deposit::create($validateData);
        return redirect()->back()->with('success', 'Deposit Has Been Done Successfuly');
    }
}
