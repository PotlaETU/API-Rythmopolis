<?php

use App\Models\Artiste;
use App\Models\Genre;
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
        Schema::create('artiste_genre', function (Blueprint $table) {
            $table->foreignId(Artiste::class)->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId(Genre::class)->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artiste_genre');
    }
};
