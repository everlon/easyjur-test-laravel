<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // EAP: Chamando o Seeder de Permissões por Spatie.
        $this->call([PermissionSeeder::class]);
    }
}
