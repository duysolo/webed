<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingsDatabaseSeeder extends Seeder
{
    protected $table = 'settings';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'site_title' => 'WebEd - v2',
            'site_logo' => '',
            'site_keywords' => 'WebEd,Laravel CMS,Laravel Website Editor',
            'site_description' => 'WebEd - Laravel Website Editor',
            'google_analytics' => '',
            'default_language' => 1,
            'dashboard_language' => 1,
            'construction_mode' => 0,
            'show_admin_bar' => 1,
        ];

        foreach ($settings as $key => $row) {
            \WebEd\Base\Settings\Models\EloquentSetting::create([
                'option_key' => $key,
                'option_value' => $row,
            ]);
        }
    }
}