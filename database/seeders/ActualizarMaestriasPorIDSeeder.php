<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActualizarMaestriasPorIDSeeder extends Seeder
{
    public function run()
    {
        $maestrias = [
            1 => [
                'inscripcion' => 0,
                'matricula' => 200,
                'arancel' => 1800,
            ],
            2 => [
                'inscripcion' => 0,
                'matricula' => 250,
                'arancel' => 3100,
            ],
            3 => [
                'inscripcion' => 0,
                'matricula' => 350,
                'arancel' => 3650,
            ],
            4 => [
                'inscripcion' => 0,
                'matricula' => 350,
                'arancel' => 3650,
            ],
            5 => [
                'inscripcion' => 0,
                'matricula' => 150,
                'arancel' => 3500,
            ],
            6 => [
                'inscripcion' => 0,
                'matricula' => 250,
                'arancel' => 3500,
            ],
            7 => [
                'inscripcion' => 0,
                'matricula' => 100,
                'arancel' => 3100,
            ],
            8 => [
                'inscripcion' => 0,
                'matricula' => 350,
                'arancel' => 3650,
            ],
            9 => [
                'inscripcion' => 0,
                'matricula' => 250,
                'arancel' => 3750,
            ],
            // Agrega más registros según sea necesario
        ];

        foreach ($maestrias as $id => $valores) {
            DB::table('maestrias')
                ->where('id', $id)
                ->update($valores);
        }
    }
}

