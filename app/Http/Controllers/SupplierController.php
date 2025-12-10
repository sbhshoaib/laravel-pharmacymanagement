<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = DB::select("SELECT * FROM suppliers ORDER BY Name");
        
        foreach ($suppliers as $supplier) {
            $purchaseCount = DB::selectOne("SELECT COUNT(*) as count FROM inventory WHERE Supplier_ID = ?", [$supplier->Supplier_ID]);
            $supplier->purchase_count = $purchaseCount ? $purchaseCount->count : 0;
        }
        
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|max:100',
            'Contact_Person' => 'nullable|max:100',
            'Email' => 'nullable|email|max:100',
            'Phone' => 'required|max:20',
            'Address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sql = "INSERT INTO suppliers (Name, Contact_Person, Email, Phone, Address) VALUES (?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $request->Name,
            $request->Contact_Person,
            $request->Email,
            $request->Phone,
            $request->Address
        ]);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = DB::selectOne("SELECT * FROM suppliers WHERE Supplier_ID = ?", [$id]);
        
        if (!$supplier) {
            return redirect()->route('suppliers.index')
                             ->with('error', 'Supplier not found');
        }
        
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|max:100',
            'Contact_Person' => 'nullable|max:100',
            'Email' => 'nullable|email|max:100',
            'Phone' => 'required|max:20',
            'Address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sql = "UPDATE suppliers SET Name = ?, Contact_Person = ?, Email = ?, Phone = ?, Address = ? WHERE Supplier_ID = ?";
        DB::update($sql, [
            $request->Name,
            $request->Contact_Person,
            $request->Email,
            $request->Phone,
            $request->Address,
            $id
        ]);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $purchaseCount = DB::selectOne("SELECT COUNT(*) as count FROM inventory WHERE Supplier_ID = ?", [$id]);
        
        if ($purchaseCount && $purchaseCount->count > 0) {
            return redirect()->route('suppliers.index')
                             ->with('error', 'Cannot delete supplier as they have associated purchases.');
        }
        
        DB::delete("DELETE FROM suppliers WHERE Supplier_ID = ?", [$id]);
        
        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier deleted successfully.');
    }
}