<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Department;
use App\Models\User;

/*
| -------------------------------------
|  The 'requisitions' table migration.
| -------------------------------------
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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Department::class)
                ->constained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->constained()
                ->cascadeOnDelete();
            $table->string('subject');
            $table->text('message')
                ->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->text('remarks')
                ->nullable();
            $table->timestamp('approved_at')
                ->nullable();
            $table->timestamp('requested_at')
                ->nullable();
            $table->timestamp('updated_at')
                ->nullable();
        });
    }

    /*
    | ---------------------
    |  Reverse the migrations
    | ---------------------
    */
    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
