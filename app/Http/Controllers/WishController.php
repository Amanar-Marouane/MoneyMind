<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wish;
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

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'cost' => 'required|integer|min:1',
        ]);
        $validateData['user_id'] = Auth::id();
        Wish::create($validateData);

        return redirect()->back()->with('Your Wish Has Been Added');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $wish = Wish::find($id);
            $wish->delete();
            return redirect()->back()->with('success', 'Wish Has Been Removed');
        }
        return redirect()->back()->with('error', 'Something Went Wrong');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $wish = Wish::find($id);
            $wish->name = $request->name;
            $wish->cost = $request->cost;
            $wish->save();
            return redirect()->back()->with('success', 'Wish Has Been Updated');
        }
        return redirect()->back()->with('error', 'Something Went Wrong');
    }
}
