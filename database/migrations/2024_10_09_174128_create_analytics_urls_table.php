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
        Schema::create('analytics_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapping_url_id')->constrained();
            $table->ipAddress('visitor_IP');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->dateTimeTz('visited_at', precision: 0);
            // $table->geography('coordinates', subtype: 'point', srid: 4326)->nullable();
            $table->string('coordinates')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_urls');
    }
};
