<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\History;

class CategoryController extends Controller
{
    public function index() {
        $category = Category::all();

        return view('pages.admin.categories.index', compact('category'));
    }

    public function create() {
        $category = Category::all();

        return view('pages.admin.categories.create', compact('category'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        if ($category) {
            History::create([
                'change_detail' => 'Category created successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category')->with('Success', 'Category created successfully.');
        }
        return redirect()->route('admin.create.category')->with('Error', 'Category not found.');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);

        return view('pages.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id) {
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
                'change_detail' => 'Category updated successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category')->with('Success', 'Category updated successfully.');
        }
        return redirect()->route('admin.create.category')->with('Error', 'Category not found.');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();

        if($category) {
            History::create([
                'change_detail' => 'Category deleted successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category')->with('Success', 'Category deleted successfully.');
        } else {
            return redirect()->route('admin.index.category')->with('Error', 'Category not found.');
        }
    }
}
