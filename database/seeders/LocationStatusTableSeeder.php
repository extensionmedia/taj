<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('location_statuses')->delete();
        
        \DB::table('location_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'location_status' => 'RESERVATION',
                'is_default' => 1,
            'color' => 'rgba(255,220,0,0.5)',
            ),
            1 => 
            array (
                'id' => 2,
                'location_status' => 'LOCATION',
                'is_default' => 0,
            'color' => 'rgba(46,204,64,0.5)',
            ),
            2 => 
            array (
                'id' => 3,
                'location_status' => 'TERMINER',
                'is_default' => 0,
                'color' => '-1',
            ),
            3 => 
            array (
                'id' => 4,
                'location_status' => 'ANNULER',
                'is_default' => 0,
            'color' => 'rgba(255,65,54,0.5)',
            ),
        ));
        
        
    }
}