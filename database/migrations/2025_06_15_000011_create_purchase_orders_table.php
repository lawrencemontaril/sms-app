<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Requisition;

/*
| ----------------------------------------
|  The 'purchase_orders' table migration.
| ----------------------------------------
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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Requisition::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('status', ['ordered', 'delivered', 'cancelled'])
                ->default('ordered');
            $table->date('delivery_date');
            $table->timestamp('delivered_at')
                ->nullable();
            $table->timestamp('ordered_at')
                ->nullable();
            $table->timestamp('updated_at')
                ->nullable();
        });
    }

    /*
    | -------------------------
    |  Reverse the migrations.
    | -------------------------
    */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
