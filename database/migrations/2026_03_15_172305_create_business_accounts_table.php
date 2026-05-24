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
        Schema::create('business_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_type_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->string('license_number')->unique();
             $table->string('business_name_ar');
           $table->string('business_name_en');
          $table->json('description')->nullable();
         $table->decimal('latitude',10,7)->nullable();
           $table->decimal('longitude',10,7)->nullable();
           $table->enum('status',['pending','accepted','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_accounts');
    }
};
