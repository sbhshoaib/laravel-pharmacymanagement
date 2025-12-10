<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::select("SELECT * FROM customer ORDER BY Name");
        
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'required|max:20',
            'address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sql = "INSERT INTO customer (Name, Email, Phone, Address, Registration_Date) VALUES (?, ?, ?, ?, CURDATE())";
        DB::insert($sql, [
            $request->name,
            $request->email,
            $request->phone,
            $request->address
        ]);

        return redirect()->route('customers.index')
                         ->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $customer = DB::selectOne("SELECT * FROM customer WHERE Customer_ID = ?", [$id]);
        
        if (!$customer) {
            return redirect()->route('customers.index')
                             ->with('error', 'Customer not found');
        }
        
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'required|max:20',
            'address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sql = "UPDATE customer SET Name = ?, Email = ?, Phone = ?, Address = ? WHERE Customer_ID = ?";
        DB::update($sql, [
            $request->name,
            $request->email,
            $request->phone,
            $request->address,
            $id
        ]);

        return redirect()->route('customers.index')
                         ->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $salesCount = DB::selectOne("SELECT COUNT(*) as count FROM sales WHERE Customer_ID = ?", [$id]);
        
        if ($salesCount && $salesCount->count > 0) {
            return redirect()->route('customers.index')
                             ->with('error', 'Cannot delete customer as they have sales records.');
        }
        
        DB::delete("DELETE FROM customer WHERE Customer_ID = ?", [$id]);
        
        return redirect()->route('customers.index')
                         ->with('success', 'Customer deleted successfully.');
    }
}
