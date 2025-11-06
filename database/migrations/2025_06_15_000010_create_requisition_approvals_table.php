<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Requisition;
use App\Models\User;

/*
| ----------------------------------------------
|  The 'requisition_approvals' table migration.
| ----------------------------------------------
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
        Schema::create('requisition_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Requisition::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('role', ['department_head', 'finance']);
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->text('remarks')
                ->nullable();
            $table->timestamp('approved_at')
                ->nullable();
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
        Schema::dropIfExists('requisition_approvals');
    }
};
