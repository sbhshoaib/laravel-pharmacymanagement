<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DosageController extends Controller
{
    public function index()
    {

        $dosages = DB::select("SELECT * FROM dosage ORDER BY name");
        

        foreach ($dosages as $dosage) {
            $medicineCount = DB::selectOne("SELECT COUNT(*) as count FROM medicines WHERE dosage_id = ?", [$dosage->id]);
            $dosage->medicine_count = $medicineCount ? $medicineCount->count : 0;
        }
        
        return view('dosages.index', compact('dosages'));
    }

    public function create()
    {
        return view('dosages.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:dosage,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $sql = "INSERT INTO dosage (name) VALUES (?)";
        DB::insert($sql, [$request->name]);

        return redirect()->route('dosages.index')
                         ->with('success', 'Dosage created successfully.');
    }

    public function edit($id)
    {
        $dosage = DB::selectOne("SELECT * FROM dosage WHERE id = ?", [$id]);
        
        if (!$dosage) {
            return redirect()->route('dosages.index')
                             ->with('error', 'Dosage not found');
        }
        
        return view('dosages.edit', compact('dosage'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:dosage,name,'.$id.',id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $sql = "UPDATE dosage SET name = ? WHERE id = ?";
        DB::update($sql, [$request->name, $id]);

        return redirect()->route('dosages.index')
                         ->with('success', 'Dosage updated successfully.');
    }

    public function destroy($id)
    {

        $medicineCount = DB::selectOne("SELECT COUNT(*) as count FROM medicines WHERE dosage_id = ?", [$id]);
        
        if ($medicineCount && $medicineCount->count > 0) {
            return redirect()->route('dosages.index')
                             ->with('error', 'Cannot delete dosage as it is used by medicines.');
        }
        

        DB::delete("DELETE FROM dosage WHERE id = ?", [$id]);
        
        return redirect()->route('dosages.index')
                         ->with('success', 'Dosage deleted successfully.');
    }
}
