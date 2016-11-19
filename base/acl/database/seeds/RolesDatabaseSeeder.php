<?php

use Illuminate\Database\Seeder;

class RolesDatabaseSeeder extends Seeder
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
         * Register roles
         */
        $roles = [
            [
                'name' => 'Super admin',
                'slug' => 'super-admin'
            ],
            [
                'name' => 'Administrator',
                'slug' => 'admin'
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff'
            ]
        ];
        foreach ($roles as $key => $row) {
            \WebEd\Base\ACL\Models\EloquentRole::create($row);
        }

        $superAdmin = \WebEd\Base\ACL\Models\EloquentRole::where('slug', '=', 'super-admin')->first();

        /**
         * Register role to user
         */
        $user = \WebEd\Base\Users\Models\EloquentUser::find(1);
        $user->roles()->sync([$superAdmin->id]);
    }
}
