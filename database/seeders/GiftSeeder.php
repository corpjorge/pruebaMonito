<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gifts')->insert([
            'id' => 1,
            'name' => 'Vajilla',
            'date' => '2021-07-21',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 2,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-07-22',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 3,
            'name' => 'Computador Portátil',
            'date' => '2021-07-23',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 4,
            'name' => 'Celular',
            'date' => '2021-07-24',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 5,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-07-25',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 6,
            'name' => 'Juego de Toallas',
            'date' => '2021-07-26',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 7,
            'name' => 'Bicicleta de Turismo',
            'date' => '2021-07-27',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 8,
            'name' => 'Morral para computador',
            'date' => '2021-07-28',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 9,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-07-29',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 10,
            'name' => 'Gafas deportivas',
            'date' => '2021-07-30',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 11,
            'name' => 'Olla a presión',
            'date' => '2021-07-31',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 12,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-08-01',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 13,
            'name' => 'Morral para computador',
            'date' => '2021-08-02',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 14,
            'name' => 'Morral y Paraguas',
            'date' => '2021-08-03',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 15,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-08-04',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 16,
            'name' => 'Canguro Dama',
            'date' => '2021-08-05',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 17,
            'name' => 'Sanduchera',
            'date' => '2021-08-06',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 18,
            'name' => 'Set de 18 copas',
            'date' => '2021-08-07',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 19,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-08-08',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 20,
            'name' => 'Gafas deportivas',
            'date' => '2021-08-09',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 21,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-08-10',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 22,
            'name' => 'Morral para computador',
            'date' => '2021-08-11',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 23,
            'name' => 'Juego de Golfito',
            'date' => '2021-08-12',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 24,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-08-13',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 25,
            'name' => 'TV de 32 ',
            'date' => '2021-08-14',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 26,
            'name' => 'Morral para computador',
            'date' => '2021-08-15',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 27,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-08-16',
            'exception' => '1',
        ]);

        DB::table('gifts')->insert([
            'id' => 28,
            'name' => 'Canguro Dama',
            'date' => '2021-08-17',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 29,
            'name' => 'Kit de utensilios para vino',
            'date' => '2021-08-18',
            'exception' => '',
        ]);

        DB::table('gifts')->insert([
            'id' => 30,
            'name' => 'Bono FEDEF $300,000',
            'date' => '2021-08-19',
            'exception' => '1',
        ]);

    }
}
