<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\History;

class CategoryController extends Controller
{
    public function index(Request $request)
    {


            $search = $request->input('search');
        if ($search) {
            $category = Category::where('name', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $category = Category::paginate(10);
        }
    
        return view('pages.admin.categories.index', compact('category'));
    }


    public function create()
    {
        $category = Category::all();

        return view('pages.admin.categories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        if ($category) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' created category ' . $category->name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category')->with('success', Auth::user()->first_name . ' created category ' . $category->name . ' successfully.');
        }
        return redirect()->route('admin.create.category')->with('error', 'Category not found.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('pages.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'updated_at',
        ]);

        if ($category) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' updated category ' . $category->name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category')->with('success', Auth::user()->first_name . ' updated category ' . $category->name . ' successfully.');
        }
        return redirect()->route('admin.create.category')->with('error', 'Category not found.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' deleted category ' . $category->name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category');
        }
        return redirect()->route('admin.index.category');
    }
}
