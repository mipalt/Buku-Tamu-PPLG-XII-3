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
          Schema::create('guest_parents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);             
            $table->string('student_name', 100);
            $table->string('rayon', 10);
            $table->string('address', 150);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->text('purpose');
            $table->string('signature_path', 150);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_parents');
    }
};
