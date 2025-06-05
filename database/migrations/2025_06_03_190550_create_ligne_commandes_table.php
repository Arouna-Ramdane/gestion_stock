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
    Schema::create('ligne_commandes', function (Blueprint $table) {
        $table->id('lign_id');
        $table->integer('prix_ligne');
        $table->integer('commande_id'); 
        $table->integer('produit_id');
        $table->timestamps();
        $table->foreign('commande_id')->references('commande_id')->on('commandes');
        $table->foreign('produit_id')->references('produit_id')->on('produits');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_commandes');
    }
};
