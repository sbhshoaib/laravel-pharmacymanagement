<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GenericController extends Controller
{
    public function index()
    {

        $generics = DB::select("SELECT * FROM generics ORDER BY name");
        

        foreach ($generics as $generic) {
            $result = DB::select("SELECT COUNT(*) as count FROM medicines WHERE generic_id = ?", [$generic->id]);
            $generic->medicine_count = $result ? $result[0]->count : 0;
        }
        
        return view('generics.index', compact('generics'));
    }

    public function create()
    {
        return view('generics.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:generics,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $sql = "INSERT INTO generics (name) VALUES (?)";
        DB::insert($sql, [$request->name]);

        return redirect()->route('generics.index')
                         ->with('success', 'Generic created successfully.');
    }

    public function edit($id)
    {
        $generic = DB::selectOne("SELECT * FROM generics WHERE id = ?", [$id]);
        
        if (!$generic) {
            return redirect()->route('generics.index')
                             ->with('error', 'Generic not found');
        }
        
        return view('generics.edit', compact('generic'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:generics,name,'.$id.',id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $sql = "UPDATE generics SET name = ? WHERE id = ?";
        DB::update($sql, [$request->name, $id]);

        return redirect()->route('generics.index')
                         ->with('success', 'Generic updated successfully.');
    }

    public function destroy($id)
    {

        $medicineCount = DB::selectOne("SELECT COUNT(*) as count FROM medicines WHERE generic_id = ?", [$id]);
        
        if ($medicineCount && $medicineCount->count > 0) {
            return redirect()->route('generics.index')
                             ->with('error', 'Cannot delete generic as it is used by medicines.');
        }
        

        DB::delete("DELETE FROM generics WHERE id = ?", [$id]);
        
        return redirect()->route('generics.index')
                         ->with('success', 'Generic deleted successfully.');
    }
}
