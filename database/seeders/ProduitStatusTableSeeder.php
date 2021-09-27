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
                'style'=>'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'
            ),
            1 =>
            array (
                'id' => 3,
                'produit_status' => 'Archivé',
                'is_default' => 0,
                'status' => 1,
                'style'=>'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800'
            ),
            4 =>
            array (
                'id' => 6,
                'produit_status' => 'En préparation',
                'is_default' => 1,
                'status' => 1,
                'style'=>'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800'
            ),
        ));


    }
}
