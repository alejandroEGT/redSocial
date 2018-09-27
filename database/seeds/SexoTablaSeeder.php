<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SexoTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sexo')->insert([
        	['sexo' => 'Mujer'],
        	['sexo' => 'Hombre']
        ]);
    }
}
