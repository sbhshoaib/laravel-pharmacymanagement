<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = DB::select("
            SELECT i.*, m.name as medicine_name, s.Name as supplier_name 
            FROM inventory i 
            JOIN medicines m ON i.Medicine_ID = m.id 
            LEFT JOIN suppliers s ON i.Supplier_ID = s.Supplier_ID 
            ORDER BY i.Purchase_Date DESC
        ");
        
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = DB::select("SELECT * FROM suppliers ORDER BY Name");
        $medicines = DB::select("SELECT * FROM medicines ORDER BY name");
        
        return view('purchases.create', compact('suppliers', 'medicines'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medicine_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'batch_number' => 'required|string|max:50',
            'expiry_date' => 'required|date',
            'purchase_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            // Add to inventory
            $sql = "INSERT INTO inventory (Medicine_ID, Batch_Number, Quantity, Expiry_Date, Purchase_Date, Supplier_ID) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            DB::insert($sql, [
                $request->medicine_id,
                $request->batch_number,
                $request->quantity,
                $request->expiry_date,
                $request->purchase_date,
                $request->supplier_id
            ]);
            
            // Update medicine stock
            DB::update("UPDATE medicines SET stock_quantity = stock_quantity + ? WHERE id = ?", [
                $request->quantity, 
                $request->medicine_id
            ]);
            
            DB::commit();
            
            return redirect()->route('purchases.index')
                             ->with('success', 'Purchase recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error recording purchase: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $purchase = DB::selectOne("
            SELECT i.*, m.name as medicine_name, g.name as generic_name, s.Name as supplier_name,
                   s.Contact_Person, s.Email as supplier_email, s.Phone as supplier_phone 
            FROM inventory i 
            JOIN medicines m ON i.Medicine_ID = m.id 
            LEFT JOIN generics g ON m.generic_id = g.id 
            LEFT JOIN suppliers s ON i.Supplier_ID = s.Supplier_ID 
            WHERE i.Inventory_ID = ?
        ", [$id]);
        
        if (!$purchase) {
            return redirect()->route('purchases.index')->with('error', 'Purchase record not found');
        }
        
        return view('purchases.show', compact('purchase'));
    }

    public function destroy($id)
    {
        $inventory = DB::selectOne("SELECT * FROM inventory WHERE Inventory_ID = ?", [$id]);
        
        if (!$inventory) {
            return redirect()->route('purchases.index')->with('error', 'Purchase record not found');
        }
        
        DB::beginTransaction();
        
        try {
            // Update medicine stock (reduce)
            DB::update("UPDATE medicines SET stock_quantity = stock_quantity - ? WHERE id = ?", [
                $inventory->Quantity,
                $inventory->Medicine_ID
            ]);
            
            // Delete inventory record
            DB::delete("DELETE FROM inventory WHERE Inventory_ID = ?", [$id]);
            
            DB::commit();
            
            return redirect()->route('purchases.index')->with('success', 'Purchase record deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('purchases.index')->with('error', 'Error deleting purchase: ' . $e->getMessage());
        }
    }
}
