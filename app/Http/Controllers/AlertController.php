<?php

namespace App\Http\Controllers;

use App\Models\{Category, User, Alert};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $categories = Category::all();

        return view('alerts.index', [
            'categories' => $categories,
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $baseRules = [
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:cash,percentage',
        ];

        $messages = [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The type must be either cash or percentage.',
        ];

        $validatedBase = $request->validate($baseRules, $messages);

        $valueRules = [
            'value' => $validatedBase['type'] === 'percentage'
                ? ['required', 'integer', 'min:0', 'max:100']
                : ['required', 'integer', 'min:0'],
        ];

        $valueMessages = [
            'value.required' => 'The value field is required.',
            'value.integer' => 'The value must be an integer.',
            'value.min' => 'The value must be at least :min.',
            'value.max' => 'The value must not be greater than :max.',
        ];

        $validatedValue = $request->validate($valueRules, $valueMessages);

        $validateData = array_merge($validatedBase, $validatedValue);
        $validateData['user_id'] = Auth::id();

        Alert::create($validateData);

        return redirect()->back()->with('success', 'Alert has been configured.');
    }

    public function update(Request $request)
    {
        $baseRules = [
            'id' => 'required|exists:alerts,id',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:cash,percentage',
        ];

        $validatedBase = $request->validate($baseRules);

        $valueRules = [
            'value' => $validatedBase['type'] === 'percentage'
                ? ['required', 'integer', 'min:0', 'max:100']
                : ['required', 'integer', 'min:0'],
        ];

        $validatedValue = $request->validate($valueRules);
        $validateData = array_merge($validatedBase, $validatedValue);
        $validateData['user_id'] = Auth::id();

        $alert = Alert::find($validatedBase['id']);
        if (!$alert) {
            return redirect()->back()->with('error', 'Alert not found.');
        }

        $alert->update($validateData);
        return redirect()->back()->with('success', 'Alert has been updated.');
    }

    public function destroy(Request $request)
    {
        $validateData = $request->validate([
            'id' => 'required|exists:alerts,id'
        ]);
        $alert = Alert::find($validateData['id']);
        $alert->delete();
        return redirect()->back()->with('success', 'Alert has been Deleted.');
    }

    public static function budgetChecker(User $user)
    {
        return $user->budget <= $user->total_expenses();
    }
}
