<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(ProduitCategoryTableSeeder::class);
        $this->call(ProduitMarqueTableSeeder::class);
        $this->call(ProduitStatusTableSeeder::class);
        $this->call(ProduitColorTableSeeder::class);
        $this->call(ProduitTypeTableSeeder::class);
        $this->call(MagasinTableSeeder::class);
        $this->call(ProduitTableSeeder::class);
        $this->call(ProduitOfMagasinTableSeeder::class);
    }
}
