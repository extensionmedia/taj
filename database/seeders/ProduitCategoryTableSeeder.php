<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProduitCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('produit_categories')->delete();

        \DB::table('produit_categories')->insert(array (
            0 =>
            array (
                'id' => 42,
                'UID' => '82729292e90525546df04121710ad7d4',
                'produit_category' => 'lebsse kaftan ',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            1 =>
            array (
                'id' => 43,
                'UID' => '8d568e88c65300f85a138b27b779a63a',
                'produit_category' => 'les kostumes',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            2 =>
            array (
                'id' => 44,
                'UID' => 'cd4f8b630ce411152aa3cf921afcbfc3',
                'produit_category' => 'jabador',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            3 =>
            array (
                'id' => 45,
                'UID' => 'bf3689fe7842e8a7c7d23580323f2793',
                'produit_category' => 'jelaba ',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            4 =>
            array (
                'id' => 46,
                'UID' => '8e01bd4a09cf90612b4039537c7f64b5',
                'produit_category' => 'sebat derjal',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            5 =>
            array (
                'id' => 48,
                'UID' => 'ccf6db35494c542a2dc1fc0fbbd3de8e',
                'produit_category' => 'sebat densae',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            6 =>
            array (
                'id' => 50,
                'UID' => '1a1c24f42480c562af469a51895c503c',
                'produit_category' => 'elbelra',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            7 =>
            array (
                'id' => 51,
                'UID' => 'fe611ebbd92e33501d321b50463060e7',
                'produit_category' => 'koustume sri3',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            8 =>
            array (
                'id' => 52,
                'UID' => '891d2e1e3dab588ee48458256eab63c0',
                'produit_category' => 'semta',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            9 =>
            array (
                'id' => 53,
                'UID' => 'c03a2ca8a0953bf30665f705c1b2f802',
                'produit_category' => '  papillon',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            10 =>
            array (
                'id' => 54,
                'UID' => 'd2334045d8aa55a8f537a4719dc03ddf',
                'produit_category' => ' kravat',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            11 =>
            array (
                'id' => 55,
                'UID' => 'f142a873c2fe80b33164eb4469ff98fb',
                'produit_category' => ' kamissa',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            12 =>
            array (
                'id' => 56,
                'UID' => '0b7021dca5db290a1a9d1dcb3054ff44',
                'produit_category' => ' 5iminos',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            13 =>
            array (
                'id' => 57,
                'UID' => '318cd12397666a8a62a44304fbc93d2e',
                'produit_category' => ' kolee',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            14 =>
            array (
                'id' => 58,
                'UID' => '7c89a5e2ac52b99c9725bc22e2265de6',
                'produit_category' => 'sinya akte',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            15 =>
            array (
                'id' => 59,
                'UID' => '85e275a8d571461d5d400ea7036ae3dd',
                'produit_category' => 'service delhina',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 1,
            ),
            16 =>
            array (
                'id' => 60,
                'UID' => 'cc306258',
                'produit_category' => 'kappa 1ps',
                'parent_id' => -1,
                'is_default' => 0,
                'status' => 0,
            ),
        ));


    }
}
