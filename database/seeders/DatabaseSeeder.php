<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => bcrypt('secret')
        ]);
    }
}
