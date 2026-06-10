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
        Schema::table('guests', function (Blueprint $table) {
            // Make phone nullable
            $table->string('phone')->nullable()->change();
            
            // Add invitation fields
            $table->string('code')->nullable()->unique()->after('id');
            $table->integer('max_passes')->default(1)->after('assistants_count');
            $table->boolean('is_confirmed')->default(false)->after('is_attending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change();
            $table->dropColumn(['code', 'max_passes', 'is_confirmed']);
        });
    }
};
