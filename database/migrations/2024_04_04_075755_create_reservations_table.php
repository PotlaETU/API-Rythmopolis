<?php

use App\Models\Client;
use App\Models\Evenement;
use App\Models\Statut;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $date = new DateTime('now');
            $table->dateTime('date_res')->default($date->format('Y-m-d H:i:s'));
            $table->integer('nb_billets');
            $table->decimal('montant', 8, 2);
            $table->string('statut')->default(Statut::EN_ATTENTE);
            $table->foreignIdFor(Evenement::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(Client::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
