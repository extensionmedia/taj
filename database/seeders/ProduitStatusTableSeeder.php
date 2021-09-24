<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProduitStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('produit_statuses')->delete();

        \DB::table('produit_statuses')->insert(array (
            0 =>
            array (
                'id' => 1,
                'produit_status' => 'Activé',
                'is_default' => 0,
                'status' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'produit_status' => 'Désactivé',
                'is_default' => 0,
                'status' => 1,
            ),
            2 =>
            array (
                'id' => 3,
                'produit_status' => 'Archivé',
                'is_default' => 0,
                'status' => 1,
            ),
            3 =>
            array (
                'id' => 4,
                'produit_status' => 'Terminé',
                'is_default' => 0,
                'status' => 1,
            ),
            4 =>
            array (
                'id' => 6,
                'produit_status' => 'En préparation',
                'is_default' => 1,
                'status' => 1,
            ),
        ));


    }
}
