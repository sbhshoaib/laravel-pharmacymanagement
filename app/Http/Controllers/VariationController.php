<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VariationController extends Controller
{
    /**
     * Display a listing of variations
     */
    public function index()
    {
        // Using raw SQL to fetch all variations
        $variations = DB::select("SELECT * FROM variation ORDER BY name");
        
        return view('variations.index', compact('variations'));
    }

    /**
     * Show the form for creating a new variation
     */
    public function create()
    {
        return view('variations.create');
    }

    /**
     * Store a newly created variation
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:variation,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Insert using raw SQL
        $sql = "INSERT INTO variation (name) VALUES (?)";
        DB::insert($sql, [$request->name]);

        return redirect()->route('variations.index')
                         ->with('success', 'Variation created successfully.');
    }

    /**
     * Show the form for editing the specified variation
     */
    public function edit($id)
    {
        $variation = DB::selectOne("SELECT * FROM variation WHERE id = ?", [$id]);
        
        if (!$variation) {
            return redirect()->route('variations.index')
                             ->with('error', 'Variation not found');
        }
        
        return view('variations.edit', compact('variation'));
    }

    /**
     * Update the specified variation
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:variation,name,'.$id.',id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update using raw SQL
        $sql = "UPDATE variation SET name = ? WHERE id = ?";
        DB::update($sql, [$request->name, $id]);

        return redirect()->route('variations.index')
                         ->with('success', 'Variation updated successfully.');
    }

    /**
     * Remove the specified variation
     */
    public function destroy($id)
    {
        // Check if variation is used by any medicine
        $usedVariations = DB::select("SELECT * FROM medicines");
        $isUsed = false;
        
        foreach ($usedVariations as $medicine) {
            $variations = json_decode($medicine->variant_id, true);
            if (is_array($variations) && in_array($id, $variations)) {
                $isUsed = true;
                break;
            }
        }
        
        if ($isUsed) {
            return redirect()->route('variations.index')
                             ->with('error', 'Cannot delete variation as it is used by medicines.');
        }
        
        // Delete using raw SQL
        DB::delete("DELETE FROM variation WHERE id = ?", [$id]);
        
        return redirect()->route('variations.index')
                         ->with('success', 'Variation deleted successfully.');
    }
}
