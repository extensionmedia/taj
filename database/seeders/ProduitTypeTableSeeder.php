<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProduitTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('produit_types')->delete();

        \DB::table('produit_types')->insert(array (
            0 =>
            array (
                'id' => 1,
                'produit_type' => 'Nouveau',
                'is_default' => 1,
                'status' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'produit_type' => 'Occasion',
                'is_default' => 0,
                'status' => 1,
            ),
        ));


    }
}
