<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersDatabaseSeeder extends Seeder
{
    protected $table = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Register users
         */
        \WebEd\Base\Users\Models\EloquentUser::create([
            'username' => 'webmaster',
            'email' => 'duyphan.developer@gmail.com',
            'first_name' => 'Tedozi',
            'last_name' => 'Manson',
            'display_name' => 'Tedozi Manson',
            'password' => 'PassCuaDev@2015',
            'sex' => 'male',
            'status' => 'activated',
            'phone' => '0984848519',
            'mobile_phone' => '0915428202',
            'avatar' => 'http://avatar.nct.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717802873_600.jpg',
        ]);
        \WebEd\Base\Users\Models\EloquentUser::create([
            'username' => 'administrator',
            'email' => 'duy.phan2509@outlook.com',
            'first_name' => 'Duy',
            'last_name' => 'Phan',
            'display_name' => 'Duy Phan',
            'password' => 'PassCuaDev@2015',
            'sex' => 'other',
            'status' => 'activated',
            'phone' => '0984848519',
            'mobile_phone' => '0915428202',
            'avatar' => 'http://avatar.nct.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717802873_600.jpg',
        ]);
    }
}
