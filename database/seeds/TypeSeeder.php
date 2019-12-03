<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{

    /**
     * @throws Exception
     */
    public function run()
    {
        DB::table('types')->insert([
            'name' => 'natural',
            'description' => 'Natural',
            'created_at' => new DateTime,
        ]);
        DB::table('types')->insert([
            'name' => 'juridico',
            'description' => 'Juridico',
            'created_at' => new DateTime,
        ]);
        DB::table('types')->insert([
            'name' => 'gubernamental',
            'description' => 'Gubernamental',
            'created_at' => new DateTime,
        ]);
    }
}
