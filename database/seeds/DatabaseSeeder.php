<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CursoSeeder::class);
        $this->command->info("CursoSeeder -> Ejecutado con éxito =)");
        $this->call(TallerSeeder::class);
        $this->command->info("TallerSeeder -> Ejecutado con éxito =)");
        $this->call(UsuarioSeeder::class);
        $this->command->info("UsuarioSeeder -> Ejecutado con éxito =)");
    }
}
