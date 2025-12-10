<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('Role_ID');
            $table->string('Role_Name');
            $table->string('Description')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            [
                'Role_Name' => 'Administrator',
                'Description' => 'Full access to all system features',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Role_Name' => 'Pharmacist',
                'Description' => 'Can manage medicines, sales and purchases',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Role_Name' => 'Cashier',
                'Description' => 'Can create sales only',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
