<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_imports', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('execute_time')->nullable();
            $table->boolean('execute')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_imports');
    }
};
