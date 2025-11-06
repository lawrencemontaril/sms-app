<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\PurchaseOrder;
use App\Models\Supply;

/*
| ---------------------------------------------
|  The 'purchase_order_items' table migration.
| ---------------------------------------------
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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PurchaseOrder::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Supply::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('quantity');
            $table->decimal('unit_cost', 8, 2);
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
        Schema::dropIfExists('purchase_order_items');
    }
};
