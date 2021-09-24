<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProduitMarqueTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('produit_marques')->delete();

        \DB::table('produit_marques')->insert(array (
            0 =>
            array (
                'id' => 1,
                'produit_marque' => 'suitment',
                'status' => 1,
                'is_default' => 0,
            ),
            1 =>
            array (
                'id' => 2,
                'produit_marque' => 'LUZARDO',
                'status' => 1,
                'is_default' => 0,
            ),
            2 =>
            array (
                'id' => 4,
                'produit_marque' => 'FC',
                'status' => 1,
                'is_default' => 0,
            ),
            3 =>
            array (
                'id' => 5,
                'produit_marque' => 'DANIEL ALVES',
                'status' => 1,
                'is_default' => 0,
            ),
            4 =>
            array (
                'id' => 6,
                'produit_marque' => 'NEW CLASS',
                'status' => 1,
                'is_default' => 0,
            ),
            5 =>
            array (
                'id' => 7,
                'produit_marque' => 'CORGATELLI',
                'status' => 1,
                'is_default' => 0,
            ),
            6 =>
            array (
                'id' => 8,
                'produit_marque' => 'WSS',
                'status' => 1,
                'is_default' => 0,
            ),
            7 =>
            array (
                'id' => 9,
                'produit_marque' => 'BAGGI',
                'status' => 1,
                'is_default' => 0,
            ),
            8 =>
            array (
                'id' => 10,
                'produit_marque' => 'QUESSTE',
                'status' => 1,
                'is_default' => 0,
            ),
            9 =>
            array (
                'id' => 11,
                'produit_marque' => 'RAMZOTTI',
                'status' => 1,
                'is_default' => 0,
            ),
            10 =>
            array (
                'id' => 17,
                'produit_marque' => 'GIOBERTI',
                'status' => 1,
                'is_default' => 1,
            ),
            11 =>
            array (
                'id' => 14,
                'produit_marque' => 'MACILA',
                'status' => 1,
                'is_default' => 0,
            ),
            12 =>
            array (
                'id' => 15,
                'produit_marque' => 'DANIEL ALVES',
                'status' => 1,
                'is_default' => 0,
            ),
            13 =>
            array (
                'id' => 16,
                'produit_marque' => 'DANIEL GALLOTTI',
                'status' => 1,
                'is_default' => 0,
            ),
        ));


    }
}
