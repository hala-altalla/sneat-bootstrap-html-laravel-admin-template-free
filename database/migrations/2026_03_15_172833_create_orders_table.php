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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
          $table->foreignId('business_account_id')->constrained()->cascadeOnDelete();

          $table->foreignId('service_id')->constrained()->cascadeOnDelete();

          $table->dateTime('needed_at')->nullable();

         $table->integer('quantity')->default(0);

         $table->text('details')->nullable();

         $table->enum('status',[
        'pending',
        'accepted',
        'rejected'
    ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};