<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(TypeSeeder::class);
        //$this->call(StatusSeeder::class);
        factory(Client::class, 200)->create();

    }
}
