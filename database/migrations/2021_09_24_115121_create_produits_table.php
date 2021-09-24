<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('produit_marque_id');
            $table->integer('produit_color_id');
            $table->integer('produit_category_id');
            $table->integer('produit_sous_category_id');
            $table->integer('produit_status_id');
            $table->integer('produit_type_id');
            $table->integer('fournisseur_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('barcode')->nullable();
            $table->string('barcode_2')->nullable();
            $table->string('UID')->nullable();
            $table->string('notes')->nullable();
            $table->date('date_reception')->nullable();
            $table->string('taille')->nullable();
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->integer('prix_achat')->default(0);
            $table->integer('prix_vente')->default(0);
            $table->integer('prix_location')->default(0);
            $table->integer('qte')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
}
