<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Department;
use App\Models\User;

/*
| ----------------------------------------
|  The 'supply_requests' table migration.
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
        Schema::create('supply_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Department::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('subject');
            $table->text('message')
                ->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');
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
        Schema::dropIfExists('supply_requests');
    }
};
