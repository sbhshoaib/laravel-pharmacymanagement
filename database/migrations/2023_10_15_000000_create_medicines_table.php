<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('medicine_id');
            $table->string('name');
            $table->unsignedBigInteger('generic_id');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('generics', function (Blueprint $table) {
            $table->id('generic_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->string('payment_method')->default('cash');
            $table->text('note')->nullable();
            $table->timestamps();
        });
        
        // Insert demo data
        $this->insertDemoData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('generics');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('sales');
    }
    
    /**
     * Insert demo data
     */
    private function insertDemoData()
    {
        // Insert generics
        DB::table('generics')->insert([
            ['name' => 'Amoxicillin', 'description' => 'Broad-spectrum antibiotic used to treat bacterial infections', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ibuprofen', 'description' => 'Non-steroidal anti-inflammatory drug used to reduce pain and inflammation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ranitidine', 'description' => 'H2 blocker that reduces stomach acid production', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cetirizine', 'description' => 'Antihistamine used to relieve allergy symptoms', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Azithromycin', 'description' => 'Antibiotic used to treat various bacterial infections', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // Insert suppliers
        DB::table('suppliers')->insert([
            [
                'name' => 'Pharma Supplies Inc.', 
                'contact_person' => 'John Smith', 
                'email' => 'john@pharmasupplies.com',
                'phone' => '555-1234',
                'address' => '123 Main St, Anytown, USA',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'MediWholes Corp.', 
                'contact_person' => 'Jane Doe', 
                'email' => 'jane@mediwholes.com',
                'phone' => '555-5678',
                'address' => '456 Oak Ave, Somewhere, USA',
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
        
        // Insert medicines
        DB::table('medicines')->insert([
            [
                'name' => 'Amoxicillin 500mg',
                'generic_id' => 1,
                'description' => 'Antibiotic used to treat bacterial infections',
                'supplier_id' => 1,
                'purchase_price' => 0.50,
                'selling_price' => 1.25,
                'stock_quantity' => 200,
                'expiry_date' => '2025-06-30',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ibuprofen 200mg',
                'generic_id' => 2,
                'description' => 'Non-steroidal anti-inflammatory drug',
                'supplier_id' => 2,
                'purchase_price' => 0.10,
                'selling_price' => 0.35,
                'stock_quantity' => 350,
                'expiry_date' => '2024-12-15',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ranitidine 150mg',
                'generic_id' => 3,
                'description' => 'Used to treat stomach acid production',
                'supplier_id' => 1,
                'purchase_price' => 0.20,
                'selling_price' => 0.75,
                'stock_quantity' => 120,
                'expiry_date' => '2024-10-10',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cetirizine 10mg',
                'generic_id' => 4,
                'description' => 'Antihistamine used to relieve allergy symptoms',
                'supplier_id' => 2,
                'purchase_price' => 0.15,
                'selling_price' => 0.60,
                'stock_quantity' => 80,
                'expiry_date' => '2025-03-22',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Azithromycin 250mg',
                'generic_id' => 5,
                'description' => 'Antibiotic used to treat bacterial infections',
                'supplier_id' => 1,
                'purchase_price' => 0.80,
                'selling_price' => 2.50,
                'stock_quantity' => 5,
                'expiry_date' => '2024-08-15',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        
        // Insert sample sales
        DB::table('sales')->insert([
            [
                'customer_id' => null,
                'total_amount' => 25.50,
                'discount' => 0,
                'paid_amount' => 25.50,
                'due_amount' => 0,
                'payment_method' => 'cash',
                'note' => 'Walk-in customer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customer_id' => null,
                'total_amount' => 47.75,
                'discount' => 2.00,
                'paid_amount' => 45.75,
                'due_amount' => 0,
                'payment_method' => 'card',
                'note' => 'Regular customer',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
