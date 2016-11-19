<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CustomFieldsDatabaseSeeder extends Seeder
{
    protected $table = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \WebEd\Plugins\CustomFields\Models\EloquentFieldGroup::create([
            'order' => 0,
            'title' => 'Homepage fields',
            'status' => 'activated',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
