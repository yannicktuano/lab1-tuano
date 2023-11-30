<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        $trashCat = Category::onlyTrashed()->latest()->paginate(5);
        return view('admin.category.category', compact('categories', 'trashCat'));
    }

    public function AddCat(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);


        return redirect()->back()->with('success', 'Category Inserted Successfully');
    }
    public function Edit($id)
    {
        $categories = Category::find($id);
        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request, $id)
    {
        Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
        ]);
        return Redirect()->route('AllCat')->with('success', 'Updated Succesfully');
    }

    public function RemoveCat($id)
    {
        $remove = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Removed Successfully');
    }

    public function RestoreCat($id)
    {
        $restore = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restored Successfully');
    }

    public function DeleteCat($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Deleted Successfully');
    }
}