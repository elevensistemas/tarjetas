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
        Schema::create('event_settings', function (Blueprint $table) {
            $table->id();
            $table->string('quinceanera_name')->default('Bianca');
            $table->dateTime('event_date');
            $table->string('event_place');
            $table->string('event_address');
            $table->text('google_maps_url');
            $table->text('google_maps_share_url');
            $table->string('dress_code')->default('Elegante Sport');
            $table->text('dress_code_description')->nullable();
            $table->string('hero_text')->default('Mis 15');
            $table->string('hero_subtext')->default('Te invito a celebrar una noche inolvidable');
            $table->text('quinceanera_message')->nullable();
            $table->json('design_settings')->nullable();
            $table->string('hero_image_path')->nullable();
            $table->string('monogram_path')->nullable();
            
            // WhatsApp Configuration
            $table->string('whatsapp_phone')->nullable();
            $table->text('whatsapp_message')->nullable();
            $table->boolean('whatsapp_enabled')->default(true);
            
            // Gifts / Regalos Configuration
            $table->string('gifts_alias')->nullable();
            $table->string('gifts_cbu')->nullable();
            $table->text('gifts_text')->nullable();
            $table->string('gifts_qr_path')->nullable();
            $table->boolean('gifts_enabled')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_settings');
    }
};
