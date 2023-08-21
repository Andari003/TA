<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Role::create([
            'name'=>'super_admin',
            'description'=>'Super Admin',
        ]);
         Role::create([
            'name'=>'admin',
            'description'=>'Adimin',
        ]);
         Role::create([
            'name'=>'contributor',
            'description'=>'Contributor',
        ]);
         Role::create([
            'name'=>'user',
            'description'=>'User',
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
};