<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Requisition;
use App\Models\Supply;

/*
| ------------------------------------------
|  The 'requisition_items' table migration.
| ------------------------------------------
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
        Schema::create('requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Requisition::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Supply::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('quantity');
            $table->decimal('estimated_cost', 8, 2);
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
        Schema::dropIfExists('requisition_items');
    }
};
