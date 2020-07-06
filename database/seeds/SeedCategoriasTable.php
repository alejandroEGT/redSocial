<?php

use Illuminate\Database\Seeder;

class SeedCategoriasTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categoria_pymes')->insert([
        	// ['value' =>'-1', 'text' => 'Seleccione..' ], 
            ['id' =>'1', 'text' => 'Gastronómico'  ], 
            ['id' =>'2', 'text' => 'Turístico'  ],  
            ['id' =>'3', 'text' => 'Cuidado personal'  ],  
            ['id' =>'4', 'text' => 'Entretenimiento y Ocio'  ], 
            ['id' =>'5', 'text' => 'tecnológico' ],   
            ['id' =>'6', 'text' => 'Deporte' ],           
            ['id' =>'7', 'text' => 'Artesanía'],  
            ['id' =>'8', 'text' => 'Belleza' ], 
        ]);
    }
}
