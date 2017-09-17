<?php

namespace Tests\Feature\WebEd;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use WebEd\Base\ACL\Models\Role;
use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\ModulesManagement\Repositories\Contracts\CoreModuleRepositoryContract;
use WebEd\Base\ModulesManagement\Repositories\CoreModuleRepository;
use WebEd\Base\Providers\InstallModuleServiceProvider;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class InstallCmsTest extends TestCase
{
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var CoreModuleRepository
     */
    protected $coreModuleRepository;

    /**
     * @var Role
     */
    protected $role;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInstall()
    {
        try {
            Artisan::call('key:generate');

            $this->registerBaseInstallServiceProvider();

            $this->roleRepository = app(RoleRepositoryContract::class);

            $this->userRepository = app(UserRepositoryContract::class);

            $this->coreModuleRepository = app(CoreModuleRepositoryContract::class);

            $this->createSuperAdminRole();

            $this->createSuperAdminUser();

            $this->registerInstallModuleServices();

            $this->finish();

            $this->assertTrue(true);
        } catch (\Exception $exception) {
            $this->assertTrue(false, $exception->getMessage());
        }
    }

    protected function registerBaseInstallServiceProvider()
    {
        $this->app->register(InstallModuleServiceProvider::class);
    }

    protected function createSuperAdminRole()
    {
        $this->role = $this->roleRepository->findWhereOrCreate([
            'slug' => 'super-admin',
        ], [
            'name' => 'Super Admin',
        ]);
    }

    protected function createSuperAdminUser()
    {
        $user = $this->userRepository->findWhereOrCreate([
            'username' => 'admin',
            'email' => 'admin@webed.com',
        ], [
            'password' => 'webed',
            'first_name' => 'Admin',
        ]);

        $this->role->users()->save($user);
    }

    protected function registerInstallModuleServices()
    {
        $data = [
            'alias' => 'webed-core',
        ];

        $cmsVersion = get_cms_version();

        $baseCore = $this->coreModuleRepository->findWhere($data);

        if (!$baseCore) {
            $this->coreModuleRepository->create(array_merge($data, [
                'installed_version' => $cmsVersion,
            ]));
        } else {
            $this->coreModuleRepository->update($baseCore, [
                'installed_version' => get_cms_version(),
            ]);
        }

        $modules = get_core_module()->where('namespace', '!=', 'WebEd\Base');

        $corePackages = get_composer_modules();

        foreach ($modules as $module) {
            $namespace = str_replace('\\\\', '\\', $module['namespace'] . '\Providers\InstallModuleServiceProvider');
            if (class_exists($namespace)) {
                $this->app->register($namespace);
            }
            $currentPackage = $corePackages->where('name', '=', $module['repos'])->first();
            $data = [
                'alias' => $module['alias'],
            ];
            if ($currentPackage) {
                $data['installed_version'] = isset($module['version']) ? $module['version'] : $currentPackage['version'];
            }
            $coreModule = $this->coreModuleRepository->findWhere([
                'alias' => $module['alias'],
            ]);
            $this->coreModuleRepository->createOrUpdate($coreModule, $data);
        }
    }

    public function finish()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'webed-public-assets',
            '--force' => true,
        ]);

        Artisan::call('cache:clear');

        Artisan::call('view:clear');

        session()->flush();

        session()->regenerate();
    }
}
