<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    public function index()
    {
        $sql = "
            SELECT m.*, g.name as generic_name, d.name as dosage_name, p.name as pharma_name,
            c.Name as category_name
            FROM medicines m 
            LEFT JOIN generics g ON m.generic_id = g.id 
            LEFT JOIN dosage d ON m.dosage_id = d.id 
            LEFT JOIN pharmaceuticals p ON m.pharma_id = p.id
            LEFT JOIN category c ON m.category_id = c.Category_ID
            ORDER BY m.id DESC
        ";
        $medicines = DB::select($sql);
        
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        $generics = DB::select("SELECT * FROM generics ORDER BY name");
        
        $dosages = DB::select("SELECT * FROM dosage ORDER BY name");
        
        $pharmaceuticals = DB::select("SELECT * FROM pharmaceuticals ORDER BY name");
        
        $variations = DB::select("SELECT * FROM variation ORDER BY name");
        
        $categories = DB::select("SELECT * FROM category ORDER BY Name");
        
        return view('medicines.create', compact('generics', 'dosages', 'pharmaceuticals', 'variations', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'generic_id' => 'required|integer',
            'unit_price' => 'required|numeric',
            'stock_quantity' => 'nullable|integer',
            'dosage_id' => 'nullable|integer',
            'pharma_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'barcode' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/medicines'), $imageName);
            $imagePath = 'images/medicines/'.$imageName;
        }
        
        $variations = $request->input('variations', []);
        $variationsJson = json_encode($variations);

        $sql = "
            INSERT INTO medicines (
                name, generic_id, unit_price, stock_quantity, 
                dosage_id, pharma_id, barcode, image, 
                category_id, variant_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        
        DB::insert($sql, [
            $request->name,
            $request->generic_id,
            $request->unit_price,
            $request->stock_quantity ?? 0,
            $request->dosage_id,
            $request->pharma_id,
            $request->barcode,
            $imagePath,
            $request->category_id,
            $variationsJson
        ]);

        return redirect()->route('medicines.index')
                         ->with('success', 'Medicine created successfully.');
    }

    public function edit($id)
    {
        $medicine = DB::selectOne("SELECT * FROM medicines WHERE id = ?", [$id]);
        
        if (!$medicine) {
            return redirect()->route('medicines.index')
                             ->with('error', 'Medicine not found');
        }
        
        $generics = DB::select("SELECT * FROM generics ORDER BY name");
        
        $dosages = DB::select("SELECT * FROM dosage ORDER BY name");
        
        $pharmaceuticals = DB::select("SELECT * FROM pharmaceuticals ORDER BY name");
        
        $variations = DB::select("SELECT * FROM variation ORDER BY name");
        
        $categories = DB::select("SELECT * FROM category ORDER BY Name");
        
        $selectedVariations = is_array(json_decode($medicine->variant_id ?? '[]', true)) ? json_decode($medicine->variant_id ?? '[]', true) : [];
        
        return view('medicines.edit', compact(
            'medicine', 'generics', 'dosages', 'pharmaceuticals', 
            'variations', 'categories', 'selectedVariations'
        ));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'generic_id' => 'required|integer',
            'unit_price' => 'required|numeric',
            'stock_quantity' => 'nullable|integer',
            'dosage_id' => 'nullable|integer',
            'pharma_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'barcode' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $medicine = DB::selectOne("SELECT * FROM medicines WHERE id = ?", [$id]);
        
        if (!$medicine) {
            return redirect()->route('medicines.index')
                             ->with('error', 'Medicine not found');
        }

        $imagePath = $medicine->image;
        if ($request->hasFile('image')) {
            if ($medicine->image && file_exists(public_path($medicine->image))) {
                unlink(public_path($medicine->image));
            }
            
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/medicines'), $imageName);
            $imagePath = 'images/medicines/'.$imageName;
        }
        
        $variations = $request->input('variations', []);
        $variationsJson = json_encode($variations);

        $sql = "
            UPDATE medicines 
            SET 
                name = ?,
                generic_id = ?,
                unit_price = ?,
                stock_quantity = ?,
                dosage_id = ?,
                pharma_id = ?,
                barcode = ?,
                image = ?,
                category_id = ?,
                variant_id = ?
            WHERE id = ?
        ";
        
        DB::update($sql, [
            $request->name,
            $request->generic_id,
            $request->unit_price,
            $request->stock_quantity ?? 0,
            $request->dosage_id,
            $request->pharma_id,
            $request->barcode,
            $imagePath,
            $request->category_id,
            $variationsJson,
            $id
        ]);

        return redirect()->route('medicines.index')
                         ->with('success', 'Medicine updated successfully.');
    }

    public function destroy($id)
    {
        $medicine = DB::selectOne("SELECT * FROM medicines WHERE id = ?", [$id]);
        
        if (!$medicine) {
            return redirect()->route('medicines.index')
                             ->with('error', 'Medicine not found');
        }
        
        if ($medicine->image && file_exists(public_path($medicine->image))) {
            unlink(public_path($medicine->image));
        }
        
        DB::delete("DELETE FROM medicines WHERE id = ?", [$id]);
        
        return redirect()->route('medicines.index')
                         ->with('success', 'Medicine deleted successfully.');
    }
}