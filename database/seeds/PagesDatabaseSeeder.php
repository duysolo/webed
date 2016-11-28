<?php

use Illuminate\Database\Seeder;

class PagesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            'Homepage',
            'Contact Us',
            'About Us',
        ];
        foreach ($pages as $key => $row) {
            \WebEd\Base\Pages\Models\EloquentPage::create([
                'title' => $row,
                'page_template' => $row,
                'status' => 'activated',
                'order' => $key,
                'created_by' => 1
            ]);
        }
    }
}
