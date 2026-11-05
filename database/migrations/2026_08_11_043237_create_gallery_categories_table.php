<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('color')->default('blue');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default categories
        DB::table('gallery_categories')->insert([
            [
                'name' => 'Pelatihan',
                'slug' => 'pelatihan',
                'icon' => 'mdi:school',
                'color' => 'blue',
                'description' => 'Dokumentasi kegiatan pelatihan',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Magang',
                'slug' => 'magang',
                'icon' => 'mdi:briefcase',
                'color' => 'green',
                'description' => 'Dokumentasi program magang',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'icon' => 'mdi:party-popper',
                'color' => 'purple',
                'description' => 'Dokumentasi kegiatan LPK SHIROKUMA',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wisuda',
                'slug' => 'wisuda',
                'icon' => 'mdi:graduation-cap',
                'color' => 'yellow',
                'description' => 'Dokumentasi wisuda peserta',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fasilitas',
                'slug' => 'fasilitas',
                'icon' => 'mdi:building',
                'color' => 'orange',
                'description' => 'Dokumentasi fasilitas LPK SHIROKUMA',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('gallery_categories');
    }
};