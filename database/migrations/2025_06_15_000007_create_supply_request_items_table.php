<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\SupplyRequest;
use App\Models\Supply;

/*
| ---------------------------------------------
|  The 'supply_request_items' table migration.
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
        Schema::create('supply_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SupplyRequest::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Supply::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('quantity');
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
        Schema::dropIfExists('supply_request_items');
    }
};
