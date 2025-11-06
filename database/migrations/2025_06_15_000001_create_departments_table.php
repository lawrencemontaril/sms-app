<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;

/*
| ------------------------------------
|  The 'departments' table migration.
| ------------------------------------
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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('name');
            $table->string('code')
                ->unique();
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
        Schema::dropIfExists('departments');
    }
};
