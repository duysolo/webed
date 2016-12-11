<?php

use WebEd\Base\ACL\Models\EloquentRole;
use WebEd\Base\Users\Models\EloquentUser;

class CmsInstallTest extends TestCase
{
    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->app = app();
    }

    /**
     * Works like php artisan cms:install
     *
     * @return void
     */
    public function testCmsInstall()
    {
        try {
            \Artisan::call('migrate');
            $this->createSuperAdminRole();
            $this->createAdminUser();
            $this->registerInstallModuleService();

            $this->assertTrue(true);
        } catch (\Exception $exception) {
            $this->assertTrue(false);
        }
    }

    protected function createSuperAdminRole()
    {
        $role = new EloquentRole();
        $role->name = 'Super Admin';
        $role->slug = 'super-admin';
        $role->save();
    }

    protected function createAdminUser()
    {
        $user = new EloquentUser();
        $user->username = 'admin';
        $user->email = 'admin@webed.com';
        $user->password = 'test';
        $user->display_name = 'Super Admin';
        $user->first_name = 'Tedozi';
        $user->last_name = 'Manson';
        $user->save();
    }

    protected function registerInstallModuleService()
    {
        $modules = get_modules_by_type('base');
        foreach ($modules as $module) {
            $namespace = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\InstallModuleServiceProvider');
            if (class_exists($namespace)) {
                $this->app->register($namespace);
            }
        }
        \Artisan::call('vendor:publish', [
            '--tag' => 'webed-public-assets',
        ]);
    }
}
