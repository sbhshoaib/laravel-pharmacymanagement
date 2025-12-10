<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::select("SELECT * FROM category ORDER BY Name");
        
        foreach ($categories as $category) {
            $medicineCount = DB::selectOne("SELECT COUNT(*) as count FROM medicines WHERE category_id = ?", [$category->Category_ID]);
            $category->medicine_count = $medicineCount ? $medicineCount->count : 0;
        }
        
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sql = "INSERT INTO category (Name, Description) VALUES (?, ?)";
        DB::insert($sql, [$request->name, $request->description]);

        return redirect()->route('categories.index')
                         ->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = DB::selectOne("SELECT * FROM category WHERE Category_ID = ?", [$id]);
        
        if (!$category) {
            return redirect()->route('categories.index')
                             ->with('error', 'Category not found');
        }
        
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sql = "UPDATE category SET Name = ?, Description = ? WHERE Category_ID = ?";
        DB::update($sql, [$request->name, $request->description, $id]);

        return redirect()->route('categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $medicineCount = DB::selectOne("SELECT COUNT(*) as count FROM medicines WHERE category_id = ?", [$id]);
        
        if ($medicineCount && $medicineCount->count > 0) {
            return redirect()->route('categories.index')
                             ->with('error', 'Cannot delete category as it is used by medicines.');
        }
        
        DB::delete("DELETE FROM category WHERE Category_ID = ?", [$id]);
        
        return redirect()->route('categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}