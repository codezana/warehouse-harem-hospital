<?php

namespace Database\Seeders;

use Database\Factories\SystemExpirationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $this->call([
            PermissionSeeder::class,
            DefaultRoleUserPermission::class,
        ]);

       SystemExpirationFactory::new()->create();
    }
}
