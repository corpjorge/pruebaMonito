<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'id' => 1,
            'title' => '¿Qué puedo hacer como Asociado, para proteger a FEDEF del riesgo de Lavado de Activos y Financiación del Terrorismo?',
            'answer' => '1_d',
            'choices' => '{ "a": "Dudar de negocios fáciles", "b": "Siempre documentar mis transacciones", "c": "Nunca prestar los productos financieros de FEDEF para beneficio de terceros", "d": "Todas las anteriores"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 2,
            'title' => 'El correo electrónico por medio del cual puedo ejercer mis derechos de acceso, corrección, supresión, revocación o reclamo por infracción sobre mis datos personales es:',
            'answer' => '2_c',
            'choices' => '{ "a": "fedef@fedef-co.com", "b": "comunicaciones@fedef-co.com", "c": "defensorasociado@fedef-co.com", "d": "gerencia@fedef-co.com"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 3,
            'title' => 'Tres apellidos de los integrantes principales de la actual Junta Directiva, son:',
            'answer' => '3_c',
            'choices' => '{ "a": "Acero, Pérez, González ", "b": "Cárdenas, Villamil, Pedraza", "c": "González, Acero, Correa ", "d": "Pedraza, Villamil, Uribe"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 4,
            'title' => 'En qué año se abrió el vínculo de asociatividad en FEDEF',
            'answer' => '4_c',
            'choices' => '{ "a": "2015", "b": "2014", "c": "2010", "d": "2012"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 5,
            'title' => 'Productos que venden Asociados con crédito Emprendimiento FEDEF',
            'answer' => '5_d',
            'choices' => '{ "a": "Naranjas, aloe vera, moringa", "b": "Nueces, gomas de colores, kiwi", "c": "c.	Traperos, escobas, dotaciones", "d": "Bebidas vitaminadas, nueces, frutas"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 6,
            'title' => 'El plan estratégico de FEDEF, iniciado en el año actual, se centra en los años',
            'answer' => '6_a',
            'choices' => '{ "a": "2021 a 2023", "b": "2021 a 2024", "c": "2021 a 2025", "d": "2022 a 2025"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 7,
            'title' => 'Medidas que ha tomado FEDEF para prevenir propagación de Covid19',
            'answer' => '7_a',
            'choices' => '{ "a": "Aislamiento, atención virtual, cierre de todos los servicios", "b": "Servicios virtuales, exigir uso de tapabocas, gel antibacterial en oficinas", "c": "Fumigación, sólo servicio telefónico, exigencia de uso de guantes a los Asociados", "d": "Todas las anteriores"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 8,
            'title' => 'El retorno o transferencia solidaria a los Asociados, en el año 2020 totalizó',
            'answer' => '8_d',
            'choices' => '{ "a": "2078 millones de pesos", "b": "2178 millones de pesos", "c": "1978 millones de pesos", "d": "2278 millones de pesos"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 9,
            'title' => 'El día de la familia FEDEF, en el año 2017, se celebró en:',
            'answer' => '8_c',
            'choices' => '{ "a": "Un parque de Madrid", "b": "Un coliseo de Facatativá", "c": "Un polideportivo de Funza", "d": "El parque de La Florida en Bogotá"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 10,
            'title' => 'El auxilio de defunción lo otorga FEDEF, por',
            'answer' => '8_c',
            'choices' => '{ "a": "Fallecimiento por cualquier causa", "b": "Fallecimiento por causas diferentes a Covid19 y suicidio", "c": "Fallecimiento por cualquier causa excepto suicidio", "d": "Fallecimiento por cualquier causa excepto homicidio"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
