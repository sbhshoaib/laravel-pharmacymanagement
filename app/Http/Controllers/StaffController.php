<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $staff = DB::select("SELECT * FROM staff ORDER BY Name");
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff member.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $roles = DB::select("SELECT * FROM roles ORDER BY Role_Name");
        return view('staff.create', compact('roles'));
    }

    /**
     * Store a newly created staff member in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|max:100',
            'Email' => 'required|email|max:100|unique:staff,Email',
            'Phone' => 'required|max:20|unique:staff,Phone',
            'Password' => 'required|min:6|confirmed',
            'Role_ID' => 'required|exists:roles,Role_ID',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sql = "INSERT INTO staff (Name, Email, Phone, Password_Hash, Role_ID, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        DB::insert($sql, [
            $request->Name,
            $request->Email,
            $request->Phone,
            Hash::make($request->Password),
            $request->Role_ID,
            'active',
            now(),
            now()
        ]);

        return redirect()->route('staff.index')
                        ->with('success', 'Staff member created successfully.');
    }

    /**
     * Show the form for editing the specified staff member.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $staff = DB::selectOne("SELECT * FROM staff WHERE Staff_ID = ?", [$id]);
        
        if (!$staff) {
            return redirect()->route('staff.index')
                            ->with('error', 'Staff member not found');
        }
        
        $roles = DB::select("SELECT * FROM roles ORDER BY Role_Name");
        
        return view('staff.edit', compact('staff', 'roles'));
    }

    /**
     * Update the specified staff member in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'Name' => 'required|max:100',
            'Email' => 'required|email|max:100|unique:staff,Email,' . $id . ',Staff_ID',
            'Phone' => 'required|max:20|unique:staff,Phone,' . $id . ',Staff_ID',
            'Role_ID' => 'required|exists:roles,Role_ID',
            'status' => 'required|in:active,inactive',
        ];

        // Only validate password if it's provided
        if ($request->filled('Password')) {
            $rules['Password'] = 'required|min:6|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // First check if the staff member exists
        $staff = DB::selectOne("SELECT * FROM staff WHERE Staff_ID = ?", [$id]);
        
        if (!$staff) {
            return redirect()->route('staff.index')
                           ->with('error', 'Staff member not found');
        }

        // If a password was provided, update with new password
        if ($request->filled('Password')) {
            $sql = "UPDATE staff SET Name = ?, Email = ?, Phone = ?, Password_Hash = ?, 
                    Role_ID = ?, status = ?, updated_at = ? WHERE Staff_ID = ?";
            
            DB::update($sql, [
                $request->Name,
                $request->Email,
                $request->Phone,
                Hash::make($request->Password),
                $request->Role_ID,
                $request->status,
                now(),
                $id
            ]);
        } else {
            // Otherwise, update without changing the password
            $sql = "UPDATE staff SET Name = ?, Email = ?, Phone = ?, 
                    Role_ID = ?, status = ?, updated_at = ? WHERE Staff_ID = ?";
            
            DB::update($sql, [
                $request->Name,
                $request->Email,
                $request->Phone,
                $request->Role_ID,
                $request->status,
                now(),
                $id
            ]);
        }

        return redirect()->route('staff.index')
                        ->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified staff member from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Check if this is the only active admin
        $adminCount = DB::selectOne("SELECT COUNT(*) as count FROM staff WHERE Role_ID = 1 AND status = 'active'");
        $staff = DB::selectOne("SELECT * FROM staff WHERE Staff_ID = ?", [$id]);
        
        // If this is the only active admin, prevent deletion
        if ($adminCount->count <= 1 && $staff->Role_ID == 1 && $staff->status == 'active') {
            return redirect()->route('staff.index')
                           ->with('error', 'Cannot delete the only active administrator.');
        }

        // Prevent deleting yourself
        if ($staff->Staff_ID == session('staff_id')) {
            return redirect()->route('staff.index')
                           ->with('error', 'You cannot delete your own account.');
        }
        
        DB::delete("DELETE FROM staff WHERE Staff_ID = ?", [$id]);
        
        return redirect()->route('staff.index')
                        ->with('success', 'Staff member deleted successfully.');
    }
}
