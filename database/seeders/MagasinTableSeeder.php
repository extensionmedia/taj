<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MagasinTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('magasins')->delete();

        \DB::table('magasins')->insert(array (
            0 =>
            array (
                'id' => 1,
                'UID' => '3cf918f3',
                'magasin_name' => 'Taj 1111  kaftan lebssa',
                'status' => 1,
                'is_default' => 0,
                'notes' => NULL,
            ),
            1 =>
            array (
                'id' => 5,
                'UID' => 'e0d855bb',
                'magasin_name' => 'taj 2222 koustum jabador',
                'status' => 1,
                'is_default' => 0,
                'notes' => NULL,
            ),
        ));


    }
}
