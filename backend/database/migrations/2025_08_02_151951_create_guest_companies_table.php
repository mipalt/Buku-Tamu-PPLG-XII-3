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
        Schema::create('guest_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('company_name', 100);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->text('purpose');
            $table->string('signature_path', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_companies');
    }
};
