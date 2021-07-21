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
//        DB::table('questions')->insert([
//            'id' => 1,
//            'title' => '¿Qué puedo hacer como Asociado, para proteger a FEDEF del riesgo de Lavado de Activos y Financiación del Terrorismo?',
//            'answer' => '1_d',
//            'choices' => '{ "a": "Dudar de negocios fáciles", "b": "Siempre documentar mis transacciones", "c": "Nunca prestar los productos financieros de FEDEF para beneficio de terceros", "d": "Todas las anteriores (Correcta)"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 2,
//            'title' => 'El correo electrónico por medio del cual puedo ejercer mis derechos de acceso, corrección, supresión, revocación o reclamo por infracción sobre mis datos personales es:',
//            'answer' => '2_c',
//            'choices' => '{ "a": "fedef@fedef-co.com", "b": "comunicaciones@fedef-co.com", "c": "defensorasociado@fedef-co.com (Correcta)", "d": "gerencia@fedef-co.com"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 3,
//            'title' => 'Tres apellidos de los integrantes principales de la actual Junta Directiva, son:',
//            'answer' => '3_c',
//            'choices' => '{ "a": "Acero, Pérez, González ", "b": "Cárdenas, Villamil, Pedraza", "c": "González, Acero, Correa (Correcta)", "d": "Pedraza, Villamil, Uribe"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 4,
//            'title' => 'En qué año se abrió el vínculo de asociatividad en FEDEF',
//            'answer' => '4_c',
//            'choices' => '{ "a": "2015", "b": "2014", "c": "2010 (Correcta)", "d": "2012"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 5,
//            'title' => 'Productos que venden Asociados con crédito Emprendimiento FEDEF',
//            'answer' => '5_d',
//            'choices' => '{ "a": "Naranjas, aloe vera, moringa", "b": "Nueces, gomas de colores, kiwi", "c": "Traperos, escobas, dotaciones", "d": "Bebidas vitaminadas, nueces, frutas (Correcta)"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 6,
//            'title' => 'El plan estratégico de FEDEF, iniciado en el año actual, se centra en los años',
//            'answer' => '6_a',
//            'choices' => '{ "a": "2021 a 2023 (Correcta)", "b": "2021 a 2024", "c": "2021 a 2025", "d": "2022 a 2025"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 7,
//            'title' => 'Medidas que ha tomado FEDEF para prevenir propagación de Covid19',
//            'answer' => '7_a',
//            'choices' => '{ "a": "Aislamiento, atención virtual, cierre de todos los servicios (Correcta)", "b": "Servicios virtuales, exigir uso de tapabocas, gel antibacterial en oficinas", "c": "Fumigación, sólo servicio telefónico, exigencia de uso de guantes a los Asociados", "d": "Todas las anteriores"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 8,
//            'title' => 'El retorno o transferencia solidaria a los Asociados, en el año 2020 totalizó',
//            'answer' => '8_d',
//            'choices' => '{ "a": "2078 millones de pesos", "b": "2178 millones de pesos", "c": "1978 millones de pesos", "d": "2278 millones de pesos (Correcta)"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 9,
//            'title' => 'El día de la familia FEDEF, en el año 2017, se celebró en:',
//            'answer' => '9_c',
//            'choices' => '{ "a": "Un parque de Madrid", "b": "Un coliseo de Facatativá", "c": "Un polideportivo de Funza (Correcta)", "d": "El parque de La Florida en Bogotá"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 10,
//            'title' => 'El auxilio de defunción lo otorga FEDEF, por',
//            'answer' => '10_c',
//            'choices' => '{ "a": "Fallecimiento por cualquier causa", "b": "Fallecimiento por causas diferentes a Covid19 y suicidio", "c": "Fallecimiento por cualquier causa excepto suicidio (Correcta)", "d": "Fallecimiento por cualquier causa excepto homicidio"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 11,
//            'title' => '¿Cuál es el porcentaje de ahorro en los aportes sociales?',
//            'answer' => '11_a',
//            'choices' => '{ "a": "2.4% (Correcta)", "b": "4.0%", "c": "1.6%", "d": "3.0%"}',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 12,
//            'title' => '¿El pago obligatorio de los $6.100 mensuales, cubre?',
//            'answer' => '12_b',
//            'choices' => '{ "a": "Póliza funeraria", "b": "Auxilio defunción (Correcta)", "c": "Seguro de vida", "d": "Seguro de Hogar" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 13,
//            'title' => '¿Cuáles son los beneficiarios del Asociado con FEDEF?',
//            'answer' => '13_a',
//            'choices' => '{ "a": "Padres/cónyuge/hijos (Correcta)", "b": "Padres/hijos/Hermanos", "c": "Padres/Abuelos/tíos", "d": "Ninguna de las anteriores" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 14,
//            'title' => '¿Requisitos para postularse al auxilio educativo?',
//            'answer' => '14_d',
//            'choices' => '{ "a": "Antigüedad mínimo 1 año", "b": "Actualización de datos", "c": "Cumplimiento en los pagos", "d": "Todas las anteriores (Correcta)" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 15,
//            'title' => '¿De cuál ahorro voluntario puede disponer el Asociado, cuando lo requiera?',
//            'answer' => '15_c',
//            'choices' => '{ "a": "Vivienda", "b": "Navideño", "c": "Vista (Correcta)", "d": "CDAT" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 16,
//            'title' => '¿Cada cuánto tiempo debo realizar mi actualización de datos?',
//            'answer' => '16_b',
//            'choices' => '{ "a": "3 AÑOS", "b": "1 AÑO (Correcta)", "c": "5 AÑOS", "d": "2 AÑOS" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 17,
//            'title' => '¿Con qué canales cuenta FEDEF para realizar mis pagos?',
//            'answer' => '17_d',
//            'choices' => '{ "a": "PSE, BANCO BOGOTA, TRANSFERENCIA ELECTRONICA", "b": "PUNTOS DE PAGO EN LAS OFICINAS ", "c": "EFECTY, SERVIENTREGA, DIMONEX", "d": "TODAS LAS ANTERIORES (Correcta)" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 18,
//            'title' => '¿Cuáles son los canales de los que dispone FEDEF para mi  atención ?',
//            'answer' => '18_d',
//            'choices' => '{ "a": "OFICINAS, LINEAS TELEFONICAS", "b": "WHATSAPP, CORREO ELECTRONICO", "c": "REDES SOCIALES", "d": "TODAS LAS ANTERIORES (Correcta)" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 19,
//            'title' => '¿Dónde puedo conocer noticias y actualizaciones de Fedef ?',
//            'answer' => '19_c',
//            'choices' => '{ "a": "PERIODICO", "b": "REVISTAS", "c": "REDES SOCIALES, PAGINA WEB Y OFICINAS (Correcta)", "d": "NUNGUNA DE LAS ANTERIORES" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 20,
//            'title' => 'En que año se creó el fondo FEDEF',
//            'answer' => '20_c',
//            'choices' => '{ "a": "1980", "b": "1977", "c": "1971 (Correcta)", "d": "1950" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 21,
//            'title' => 'En que año se creó el fondo FEDEF',
//            'answer' => '21_c',
//            'choices' => '{ "a": "1980", "b": "1977", "c": "1971 (Correcta)", "d": "1950" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 22,
//            'title' => 'Que tasa de reconocimiento tiene el ahorro de vivienda',
//            'answer' => '22_c',
//            'choices' => '{ "a": "2% EA", "b": "4% EA", "c": "6% EA (Correcta)", "d": "Ninguna de las anteriores" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 23,
//            'title' => 'El crédito de calamidad Domestica se presta para',
//            'answer' => '23_d',
//            'choices' => '{ "a": "Gastos médicos no cubiertos por el POS", "b": "Gastos odontológicos", "c": "Gastos oftalmológicos", "d": "Todas las anteriores (Correcta)" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 24,
//            'title' => 'Una de las condiciones del crédito especial de vivienda es',
//            'answer' => '24_c',
//            'choices' => '{ "a": "56 meses", "b": "Un codeudor", "c": "Llevar como mínimo 2 años de antigüedad continuos en Fedef (Correcta)", "d": "Todas las anteriores" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 25,
//            'title' => 'El horario de atención de Funza es:',
//            'answer' => '25_d',
//            'choices' => '{ "a": "1pm a 5 pm", "b": "8am a 1 pm", "c": "8am a 3 pm", "d": "Lunes a viernes de 9 am – 5 pm sábados de 9 am – 2 pm (Correcta)" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        DB::table('questions')->insert([
//            'id' => 26,
//            'title' => 'Las oficinas de Fedef están ubicadas en:',
//            'answer' => '26_b',
//            'choices' => '{ "a": "tokio, roma, Suba", "b": "Funza, Facatativá, Suba (Correcta)", "c": "Zipaquirá, Cartagena, Funza", "d": "Fusagasugá, Facatativá, Madrid" }',
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);

        DB::table('awards')->insert([
            'id' => 1,
            'winner' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
