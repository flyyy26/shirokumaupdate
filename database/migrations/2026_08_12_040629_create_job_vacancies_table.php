<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('requirements')->nullable(); // Array of requirements
            $table->string('position_type')->nullable(); // Full-time, Part-time, Contract
            $table->string('location')->nullable();
            $table->string('salary')->nullable();
            $table->date('deadline')->nullable();
            $table->string('gender')->nullable(); // Pria, Wanita, Semua
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->string('education')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_vacancies');
    }
};