<?php

use App\Models\Evenement;
use App\Models\Type;
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
        Schema::create('type_evenement', function (Blueprint $table) {
            $table->foreignId(Evenement::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId(Type::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_evenement');
    }
};
