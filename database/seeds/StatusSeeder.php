<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{

    /**
     * @throws Exception
     */
    public function run()
    {
        DB::table('status')->insert([
            'name' => 'active',
            'description' => 'Activo',
            'created_at' => new DateTime,
        ]);
        DB::table('status')->insert([
            'name' => 'blocked',
            'description' => 'Bloqueado',
            'created_at' => new DateTime,
        ]);
    }
}
