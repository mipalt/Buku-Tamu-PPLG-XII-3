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
        Schema::create('guest_alumni', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->integer('graduation_year');
            $table->string('major', 4);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable(); // opsional
            $table->text('purpose');
            $table->string('signature_path', 150);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_alumni');
    }
};
