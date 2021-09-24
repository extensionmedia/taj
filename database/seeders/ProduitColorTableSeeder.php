<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProduitColorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('produit_colors')->delete();

        \DB::table('produit_colors')->insert(array (
            0 =>
            array (
                'id' => 1,
                'produit_color' => 'Noir',
                'status' => 1,
                'is_default' => 0,
            ),
            1 =>
            array (
                'id' => 2,
                'produit_color' => 'Gris',
                'status' => 1,
                'is_default' => 0,
            ),
            2 =>
            array (
                'id' => 3,
                'produit_color' => 'Bleu',
                'status' => 1,
                'is_default' => 0,
            ),
            3 =>
            array (
                'id' => 4,
                'produit_color' => 'Bleu Marin',
                'status' => 1,
                'is_default' => 0,
            ),
            4 =>
            array (
                'id' => 5,
                'produit_color' => 'Blanc',
                'status' => 1,
                'is_default' => 0,
            ),
            5 =>
            array (
                'id' => 6,
                'produit_color' => 'xiby besmarino',
                'status' => 1,
                'is_default' => 0,
            ),
            6 =>
            array (
                'id' => 7,
                'produit_color' => 'SEMARINO',
                'status' => 1,
                'is_default' => 0,
            ),
            7 =>
            array (
                'id' => 8,
                'produit_color' => 'ZITY',
                'status' => 1,
                'is_default' => 0,
            ),
            8 =>
            array (
                'id' => 9,
                'produit_color' => 'xiby',
                'status' => 1,
                'is_default' => 1,
            ),
        ));


    }
}
