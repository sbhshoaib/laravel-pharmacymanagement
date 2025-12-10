<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $medicineCount = DB::selectOne("SELECT COUNT(*) as total FROM medicines");
        
        $lowStockMedicines = DB::select("SELECT COUNT(*) as total FROM medicines WHERE stock_quantity < 10");
        
        $genericCount = DB::selectOne("SELECT COUNT(*) as total FROM generics");
        
        $supplierCount = DB::selectOne("SELECT COUNT(*) as total FROM suppliers");
    
        $todaySales = DB::selectOne("
            SELECT COALESCE(SUM(total_amount), 0) as total 
            FROM sales 
            WHERE DATE(created_at) = CURDATE()
        ");
        
        return view('dashboard', [
            'medicineCount' => $medicineCount ? $medicineCount->total : 0,
            'lowStockCount' => $lowStockMedicines ? $lowStockMedicines[0]->total : 0,
            'genericCount' => $genericCount ? $genericCount->total : 0,
            'supplierCount' => $supplierCount ? $supplierCount->total : 0,
            'todaySales' => $todaySales ? $todaySales->total : 0
        ]);
    }
}
