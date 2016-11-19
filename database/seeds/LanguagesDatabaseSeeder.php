<?php

use Illuminate\Database\Seeder;

class LanguagesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = database_path('seeds/languages.json');
        foreach (json_decode(file_get_contents($json)) as $key => $row) {
            \WebEd\Plugins\Languages\Models\EloquentLanguage::create([
                'name' => $row->language_name,
                'code' => $row->language_code,
                'status' => (in_array($row->language_code, ['en', 'vi'])) ? 'activated' : 'disabled',
                'order' => 0,
                'locale' => $row->default_locale,
                'tag' => $row->tag,
            ]);
        }
    }
}
