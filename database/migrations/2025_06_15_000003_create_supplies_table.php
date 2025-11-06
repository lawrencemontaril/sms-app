<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/*
| ---------------------------------
|  The 'supplies' table migration.
| ---------------------------------
*/
return new class extends Migration
{
    /*
    | ---------------------
    |  Run the migrations.
    | ---------------------
    */
    public function up(): void
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')
                ->nullable();
            $table->decimal('price', 8, 2)
                ->default(0);
            $table->unsignedBigInteger('quantity')
                ->default(0);
            $table->unsignedBigInteger('reorder_level');
            $table->timestamps();
        });
    }

    /*
    | -------------------------
    |  Reverse the migrations.
    | -------------------------
    */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
