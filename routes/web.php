<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\PharmaceuticalController;
use App\Http\Controllers\DosageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PrescriptionVerificationController;
use App\Http\Controllers\BmdcVerificationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AiSuggestController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth.check'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Generics
    Route::resource('generics', GenericController::class);
    
    // Pharmaceuticals
    Route::resource('pharmaceuticals', PharmaceuticalController::class);
    
    // Dosages
    Route::resource('dosages', DosageController::class);
    
    // Suppliers
    Route::resource('suppliers', SupplierController::class);
    
    // Medicines
    Route::resource('medicines', MedicineController::class);
    Route::get('/medicines/variation/create', [MedicineController::class, 'createVariation'])->name('medicines.variation.create');
    Route::post('/medicines/variation/store', [MedicineController::class, 'storeVariation'])->name('medicines.variation.store');
    
    // Customers
    Route::resource('customers', CustomerController::class);
    
    // Purchases
    Route::resource('purchases', PurchaseController::class);
    Route::get('/purchases/{id}/details', [PurchaseController::class, 'details'])->name('purchases.details');
    
    // Sales
    Route::resource('sales', SalesController::class);
    Route::get('/sales/barcode/{barcode}', [SalesController::class, 'findByBarcode']);
    Route::get('/sales/medicine-info/{id}', [SalesController::class, 'getMedicineInfo']);
    
    // Prescription Verification
    Route::post('/prescription/upload', [PrescriptionVerificationController::class, 'upload'])->name('prescription.upload');
    Route::post('/prescription/extract-text', [PrescriptionVerificationController::class, 'extractText'])->name('prescription.extractText');
    Route::post('/prescription/extract-bmdc', [PrescriptionVerificationController::class, 'extractBmdcNumber'])->name('prescription.extractBmdc');
    Route::post('/prescription/verify-doctor', [PrescriptionVerificationController::class, 'verifyDoctor'])->name('prescription.verifyDoctor');
    
    // BMDC Verification
    Route::get('/bmdc-verification', [BmdcVerificationController::class, 'index'])->name('bmdc.index');
    Route::post('/bmdc-verification/verify', [BmdcVerificationController::class, 'verify'])->name('bmdc.verify');
    
    // Staff Management
    Route::resource('staff', StaffController::class);
    
    // AI Suggest
    Route::get('/ai-suggest', [AiSuggestController::class, 'index'])->name('ai-suggest.index');
    Route::get('/ai-suggest/medicine-info', [AiSuggestController::class, 'medicineInfo'])->name('ai-suggest.medicine-info');
    Route::post('/ai-suggest/get-medicine-info', [AiSuggestController::class, 'getMedicineInfo'])->name('ai-suggest.get-medicine-info');
    Route::get('/ai-suggest/medicine-suggest', [AiSuggestController::class, 'medicineSuggest'])->name('ai-suggest.medicine-suggest');
    Route::post('/ai-suggest/get-suggestion', [AiSuggestController::class, 'getSuggestion'])->name('ai-suggest.get-suggestion');
});