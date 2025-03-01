<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Wish, Expense};
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

    public function buy(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user->saving_goal_progress < $request->cost) {
            return redirect()->back()->with('error', 'You Don\'t Have Enough Saving Money, Try Deposing Some Money To Your Saving Pocket');
        }
        $wish = Wish::find($request->id);
        if (!$wish) {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
        Expense::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'user_id' => Auth::id(),
        ]);
        $user->saving_goal_progress -= $request->cost;
        $user->save();
        $wish->delete();
        return redirect()->back()->with('success', 'Congrats!! Your Wish Become True');
    }
}
