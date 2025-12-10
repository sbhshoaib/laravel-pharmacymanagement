<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id('Staff_ID');
            $table->string('Name');
            $table->string('Email')->unique();
            $table->string('Phone')->unique();
            $table->string('Password_Hash');
            $table->unsignedBigInteger('Role_ID');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Insert a demo admin user
        DB::table('staff')->insert([
            'Name' => 'Admin User',
            'Email' => 'admin@example.com',
            'Phone' => '1234567890',
            'Password_Hash' => Hash::make('password'),
            'Role_ID' => 1,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
