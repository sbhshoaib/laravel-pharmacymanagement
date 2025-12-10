<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PharmaceuticalController extends Controller
{
    public function index()
    {

        $pharmaceuticals = DB::select("SELECT * FROM pharmaceuticals ORDER BY name");
        

        foreach ($pharmaceuticals as $pharmaceutical) {
            $medicineCount = DB::selectOne(
                "SELECT COUNT(*) as count FROM medicines WHERE pharma_id = ?", 
                [$pharmaceutical->id]
            );
            $pharmaceutical->medicine_count = $medicineCount ? $medicineCount->count : 0;
        }
        
        return view('pharmaceuticals.index', compact('pharmaceuticals'));
    }

    public function create()
    {
        return view('pharmaceuticals.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:pharmaceuticals,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $sql = "INSERT INTO pharmaceuticals (name) VALUES (?)";
        DB::insert($sql, [$request->name]);

        return redirect()->route('pharmaceuticals.index')
                         ->with('success', 'Pharmaceutical company created successfully.');
    }

    public function edit($id)
    {
        $pharmaceutical = DB::selectOne("SELECT * FROM pharmaceuticals WHERE id = ?", [$id]);
        
        if (!$pharmaceutical) {
            return redirect()->route('pharmaceuticals.index')
                             ->with('error', 'Pharmaceutical company not found');
        }
        
        return view('pharmaceuticals.edit', compact('pharmaceutical'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:pharmaceuticals,name,'.$id.',id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $sql = "UPDATE pharmaceuticals SET name = ? WHERE id = ?";
        DB::update($sql, [$request->name, $id]);

        return redirect()->route('pharmaceuticals.index')
                         ->with('success', 'Pharmaceutical company updated successfully.');
    }

    public function destroy($id)
    {

        $medicineCount = DB::selectOne(
            "SELECT COUNT(*) as count FROM medicines WHERE pharma_id = ?", 
            [$id]
        );
        
        if ($medicineCount && $medicineCount->count > 0) {
            return redirect()->route('pharmaceuticals.index')
                             ->with('error', 'Cannot delete pharmaceutical company as it is used by medicines.');
        }
        

        DB::delete("DELETE FROM pharmaceuticals WHERE id = ?", [$id]);
        
        return redirect()->route('pharmaceuticals.index')
                         ->with('success', 'Pharmaceutical company deleted successfully.');
    }
}
