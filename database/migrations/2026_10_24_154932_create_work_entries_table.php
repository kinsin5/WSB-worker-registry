<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('work_date');
            $table->decimal('hours', 5, 2);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'work_date']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_entries');
    }
};




$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->date('work_date');
$table->decimal('hours', 5, 2);
$table->foreignId('created_by')->constrained('users')->restrictOnDelete();
$table->timestamps();

$table->unique(['user_id', 'work_date']);