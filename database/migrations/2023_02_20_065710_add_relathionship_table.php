<?php

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
        Schema::table('transaksis', function (Blueprint $table) {

            $table->unsignedBigInteger('division_id')->nullable()->after("id");
             $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade')->onDelete('cascade');

        });

        Schema::table('areas', function (Blueprint $table) {

            $table->unsignedBigInteger('division_id')->nullable()->after("id");
             $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade')->onDelete('cascade');

        });

        Schema::table('group_equipment', function (Blueprint $table) {

            $table->unsignedBigInteger('division_id')->nullable()->after("id");
            $table->unsignedBigInteger('area_id')->nullable()->after("id");
             $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onUpdate('cascade')->onDelete('cascade');

        });

        Schema::table('equipment', function (Blueprint $table) {
             $table->unsignedBigInteger('division_id')->nullable()->after("id");
                $table->unsignedBigInteger('area_id')->nullable()->after("id");
            $table->unsignedBigInteger('group_equipment_id')->nullable()->after("id");

             $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('group_equipment_id')
                ->references('id')
                ->on('group_equipment')
                ->onUpdate('cascade')->onDelete('cascade');

        });
        Schema::table('type', function (Blueprint $table) {

            $table->unsignedBigInteger('division_id')->nullable()->after("id");
                $table->unsignedBigInteger('area_id')->nullable()->after("id");
            $table->unsignedBigInteger('group_equipment_id')->nullable()->after("id");
            $table->unsignedBigInteger('equipment_id')->nullable()->after("id");
            $table->text('content')->nullable()->after("description");

            $table->foreign('equipment_id')
                ->references('id')
                ->on('equipment')
                ->onUpdate('cascade')->onDelete('cascade');
             $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('group_equipment_id')
                ->references('id')
                ->on('group_equipment')
                ->onUpdate('cascade')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
