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
        $this->call(\UsersDatabaseSeeder::class);
        $this->call(\RolesDatabaseSeeder::class);
        $this->call(\SettingsDatabaseSeeder::class);
        $this->call(\LanguagesDatabaseSeeder::class);
        $this->call(\PagesDatabaseSeeder::class);
        $this->call(\CustomFieldsDatabaseSeeder::class);
    }
}
