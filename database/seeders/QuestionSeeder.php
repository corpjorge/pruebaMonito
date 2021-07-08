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
            'title' => 'Pregunta 1',
            'answer' => '1_d',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 2,
            'title' => 'Pregunta 2',
            'answer' => '2_c',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 3,
            'title' => 'Pregunta 3',
            'answer' => '3_b',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 4,
            'title' => 'Pregunta 4',
            'answer' => '4_a',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 5,
            'title' => 'Pregunta 5',
            'answer' => '5_a',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 6,
            'title' => 'Pregunta 6',
            'answer' => '6_b',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 7,
            'title' => 'Pregunta 7',
            'answer' => '7_c',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'id' => 8,
            'title' => 'Pregunta 8',
            'answer' => '8_d',
            'choices' => '{ "a": "jorge a", "b": "jorge b", "c": "jorge c", "d": "jorge d"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
