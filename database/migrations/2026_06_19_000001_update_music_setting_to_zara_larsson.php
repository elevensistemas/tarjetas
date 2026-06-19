<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\MusicSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $music = MusicSetting::firstOrCreate(['id' => 1]);
        $music->file_path = 'music/zara_larsson_midnight_sun.mp3';
        $music->is_active = true;
        $music->autoplay = true;
        $music->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $music = MusicSetting::find(1);
        if ($music) {
            $music->file_path = null;
            $music->save();
        }
    }
};
