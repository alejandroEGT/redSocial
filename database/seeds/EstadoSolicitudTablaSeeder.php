<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSolicitudTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_solicitud')->insert([
            ['nombre' => 'Aceptada' ],
            ['nombre' => 'Cancelada',
            ['nombre' => 'Enviada' ],
        ]);
    }
}
