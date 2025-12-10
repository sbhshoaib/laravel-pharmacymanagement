<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        session()->regenerateToken();
        return view('welcome');
    }
    

    public function index()
    {
        session()->regenerateToken();
        return view('welcome');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $input = $credentials['identifier'];
        
        $sql = "SELECT * FROM staff WHERE (Email = ? OR Phone = ?) AND status = 'active'";
        $staff = DB::selectOne($sql, [$input, $input]);

        if ($staff && Hash::check($request->password, $staff->Password_Hash)) {
        
            session([
                'staff_id' => $staff->Staff_ID,
                'name' => $staff->Name,
                'email' => $staff->Email,
                'role_id' => $staff->Role_ID
            ]);
            
            
            if ($request->remember) {
                $minutes = 43200;
                cookie('staff_id', $staff->Staff_ID, $minutes);
            }

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid credentials. Please try again.');
    }

    
    public function logout()
    {
        session()->forget(['staff_id', 'name', 'email', 'role_id']);
        
        if (request()->cookie('staff_id')) {
            cookie()->forget('staff_id');
        }
        
        return redirect('/');
    }
}
