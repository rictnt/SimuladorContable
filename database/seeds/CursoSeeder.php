<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('es_ES');
        for ($i=0; $i < 100; $i++) {
            $curs_id = \DB::table('Curso')->insertGetId(array(
                'curs_nombre' => $faker->realText(rand(10,100)),
                'curs_introduccion' => $faker->realText(rand(50,500))
            ));

            $tall_id = \DB::table('Taller')->insertGetId(array(
                'tall_nombre' => $faker->realText(rand(10,45)),
                'tall_tipo' => $faker->randomElement(array ('diagnostico','teorico','practico')),
                'tall_tiempo' => $faker->date('Y-m-d H:i:s', $max = 'now'),
                'curs_id' => $curs_id,
                'tall_rutaarchivo' => $faker->imageUrl($width = 640, $height = 480)
            ));
        }
    }
}
