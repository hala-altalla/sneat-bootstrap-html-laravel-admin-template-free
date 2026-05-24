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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title_ar');
            $table->string('title_en');
            $table->json('description')->nullable();
            $table->integer('quantity');
           $table->enum('service_type',['sale','rent']);
         //    $table->decimal('price',10,2);
         //   $table->enum('currency',['USD','SYP']);
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
        Schema::dropIfExists('services');
    }
};
