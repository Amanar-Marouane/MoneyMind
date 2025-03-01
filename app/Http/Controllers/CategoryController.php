<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    use HasFactory;

    public function index()
    {
        $categories = Category::all();

        return view('admin.categories', [
            'categories' => $categories,
        ]);
    }

    public function update(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $request->id,
        ]);

        $category = Category::find($request->id);
        if (!$category) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $category->update($validateData);

        return redirect()->back()->with('success', 'Category has been updated');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|min:2|unique:categories,name',
        ], [
            'name.min' => 'The category name must be at least 2 characters long.',
            'name.unique' => 'This category name already exists. Please choose another one.',
        ]);

        Category::create($validateData);
        return redirect()->back()->with('success', 'Category has been Added');
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
        return redirect()->back()->with('success', 'Category has been Deleted');
    }
}
