<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FournisseurTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('fournisseurs')->delete();

        \DB::table('fournisseurs')->insert(array (
            0 =>
            array (
                'id' => 5,
                'created_at' => '2019-02-11 06:46:10',
                'created_by' => 0,
                'updated_at' => NULL,
                'updated_by' => NULL,
                'fournisseur_name' => '0m kltom ',
                'telephone_1' => '',
                'telephone_2' => '',
                'notes' => '',
                'status' => 1,
                'is_default' => 0,
            ),
            1 =>
            array (
                'id' => 4,
                'created_at' => '2019-02-11 06:45:45',
                'created_by' => 0,
                'updated_at' => NULL,
                'updated_by' => NULL,
                'fournisseur_name' => 'ab rahim ',
                'telephone_1' => '',
                'telephone_2' => '',
                'notes' => '',
                'status' => 1,
                'is_default' => 0,
            ),
            2 =>
            array (
                'id' => 6,
                'created_at' => '2019-02-11 06:46:40',
                'created_by' => 0,
                'updated_at' => NULL,
                'updated_by' => NULL,
                'fournisseur_name' => '5adija',
                'telephone_1' => '',
                'telephone_2' => '',
                'notes' => '',
                'status' => 1,
                'is_default' => 0,
            ),
            3 =>
            array (
                'id' => 7,
                'created_at' => '2019-02-11 06:47:08',
                'created_by' => 0,
                'updated_at' => NULL,
                'updated_by' => NULL,
                'fournisseur_name' => 'fatima zehra',
                'telephone_1' => '',
                'telephone_2' => '',
                'notes' => '',
                'status' => 1,
                'is_default' => 0,
            ),
            4 =>
            array (
                'id' => 8,
                'created_at' => '2019-02-11 06:47:26',
                'created_by' => 0,
                'updated_at' => NULL,
                'updated_by' => NULL,
                'fournisseur_name' => 'halima',
                'telephone_1' => '',
                'telephone_2' => '',
                'notes' => '',
                'status' => 1,
                'is_default' => 1,
            ),
            5 =>
            array (
                'id' => 9,
                'created_at' => '2019-02-27 14:29:35',
                'created_by' => 0,
                'updated_at' => NULL,
                'updated_by' => NULL,
                'fournisseur_name' => 'MADE TURKY',
                'telephone_1' => '',
                'telephone_2' => '',
                'notes' => '',
                'status' => 1,
                'is_default' => 0,
            ),
        ));


    }
}
