<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_projections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('governmentId');
            $table->string('email');
            $table->decimal('debtAmount');
            $table->date('debtDueDate');
            $table->string('debtID');
            $table->boolean('send_notification')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_projections');
    }
};
