<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        $sales = DB::select("
            SELECT s.*, c.Name as customer_name, sf.Name as staff_name 
            FROM sales s 
            LEFT JOIN customer c ON s.Customer_ID = c.Customer_ID 
            LEFT JOIN staff sf ON s.Staff_ID = sf.Staff_ID 
            ORDER BY s.Sale_ID DESC
        ");
        
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = DB::select("SELECT * FROM customer ORDER BY Name");
        $medicines = DB::select("SELECT m.*, g.name as generic_name FROM medicines m LEFT JOIN generics g ON m.generic_id = g.id ORDER BY m.name");
        $staffId = session('staff_id');
        
        return view('sales.create', compact('customers', 'medicines', 'staffId'));
    }
    
    public function getMedicineInfo($id)
    {
        $medicine = DB::selectOne("
            SELECT m.*, g.name as generic_name, d.name as dosage_name, p.name as pharma_name 
            FROM medicines m 
            LEFT JOIN generics g ON m.generic_id = g.id 
            LEFT JOIN dosage d ON m.dosage_id = d.id 
            LEFT JOIN pharmaceuticals p ON m.pharma_id = p.id 
            WHERE m.id = ?
        ", [$id]);
        
        return response()->json($medicine);
    }
    
    public function getMedicineByBarcode($barcode)
    {
        $medicine = DB::selectOne("
            SELECT m.*, g.name as generic_name, d.name as dosage_name, p.name as pharma_name 
            FROM medicines m 
            LEFT JOIN generics g ON m.generic_id = g.id 
            LEFT JOIN dosage d ON m.dosage_id = d.id 
            LEFT JOIN pharmaceuticals p ON m.pharma_id = p.id 
            WHERE m.barcode = ?
        ", [$barcode]);
        
        if ($medicine) {
            return response()->json([
                'success' => true,
                'medicine' => $medicine
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Medicine not found with this barcode'
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'nullable|integer',
            'payment_method' => 'required|string|max:50',
            'medicine_ids' => 'required|array',
            'medicine_ids.*' => 'required|integer',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
            'subtotals' => 'required|array',
            'subtotals.*' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Insert into sales table
            $saleId = DB::table('sales')->insertGetId([
                'Customer_ID' => $request->customer_id ?? null,
                'Date' => now()->format('Y-m-d'),
                'Total_Amount' => $request->total_amount,
                'Payment_Method' => $request->payment_method,
                'Staff_ID' => session('staff_id'),
                'created_at' => now()
            ]);
            
            // Insert sale items
            foreach ($request->medicine_ids as $key => $medicineId) {
                DB::table('sales_item')->insert([
                    'Sale_ID' => $saleId,
                    'Medicine_ID' => $medicineId,
                    'Quantity' => $request->quantities[$key],
                    'Unit_Price' => $request->prices[$key],
                    'Subtotal' => $request->subtotals[$key]
                ]);
                
                // Update medicine stock quantity
                DB::update(
                    "UPDATE medicines SET stock_quantity = stock_quantity - ? WHERE id = ?", 
                    [$request->quantities[$key], $medicineId]
                );
            }
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('sales.show', $saleId)
                             ->with('success', 'Sale completed successfully!');
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollback();
            return back()->with('error', 'Error creating sale: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $sale = DB::selectOne("
            SELECT s.*, c.Name as customer_name, c.Phone as customer_phone, 
                   c.Email as customer_email, c.Address as customer_address,
                   sf.Name as staff_name 
            FROM sales s 
            LEFT JOIN customer c ON s.Customer_ID = c.Customer_ID 
            LEFT JOIN staff sf ON s.Staff_ID = sf.Staff_ID 
            WHERE s.Sale_ID = ?
        ", [$id]);
        
        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found');
        }
        
        $items = DB::select("
            SELECT si.*, m.name as medicine_name, g.name as generic_name 
            FROM sales_item si 
            JOIN medicines m ON si.Medicine_ID = m.id 
            LEFT JOIN generics g ON m.generic_id = g.id 
            WHERE si.Sale_ID = ?
        ", [$id]);
        
        return view('sales.show', compact('sale', 'items'));
    }
    
    public function destroy($id)
    {
        // Check if sale exists
        $sale = DB::selectOne("SELECT * FROM sales WHERE Sale_ID = ?", [$id]);
        
        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found');
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Get sale items to restore stock
            $items = DB::select("SELECT * FROM sales_item WHERE Sale_ID = ?", [$id]);
            
            // Restore stock quantities
            foreach ($items as $item) {
                DB::update(
                    "UPDATE medicines SET stock_quantity = stock_quantity + ? WHERE id = ?", 
                    [$item->Quantity, $item->Medicine_ID]
                );
            }
            
            // Delete sale items
            DB::delete("DELETE FROM sales_item WHERE Sale_ID = ?", [$id]);
            
            // Delete sale
            DB::delete("DELETE FROM sales WHERE Sale_ID = ?", [$id]);
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('sales.index')->with('success', 'Sale deleted successfully');
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollback();
            return redirect()->route('sales.index')->with('error', 'Error deleting sale: ' . $e->getMessage());
        }
    }
}
