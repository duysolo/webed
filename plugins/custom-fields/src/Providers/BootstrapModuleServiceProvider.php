<?php namespace WebEd\Plugins\CustomFields\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\CustomFields';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'webed-custom-fields',
            'piority' => 12,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Custom fields',
            'font_icon' => 'icon-briefcase',
            'link' => route('admin::custom-fields.index.get'),
            'css_class' => null,
        ]);

        /**
         * Register some rule groups
         */
        \CustomFieldRules::registerRuleGroup('Basic')
            ->registerRuleGroup('Other');

        $this->registerUsersFields();
        $this->registerPagesFields();
        $this->registerBlogFields();
    }

    private function registerUsersFields()
    {
        \CustomFieldRules::registerRule('Other', 'Logged in user', 'logged_in_user', function () {
            $userRepository = app(\WebEd\Base\Users\Repositories\Contracts\UserContract::class);

            $users = $userRepository->all([
                'created_at' => 'DESC',
            ], [
                'id',
                'username',
                'email',
            ], true);

            $userArr = [];
            foreach ($users as $user) {
                $userArr[$user->id] = $user->username . ' - ' . $user->email;
            }

            return $userArr;
        })
            ->registerRule('Other', 'Logged in user has role', 'logged_in_user_has_role', function () {
                $repository = app(\WebEd\Base\ACL\Repositories\Contracts\RoleContract::class);

                $roles = $repository->all([
                    'created_at' => 'DESC',
                ], [
                    'id',
                    'name',
                    'slug',
                ], true);

                $rolesArr = [];
                foreach ($roles as $role) {
                    $rolesArr[$role->id] = $role->name . ' - (' . $role->slug . ')';
                }

                return $rolesArr;
            });
    }

    private function registerPagesFields()
    {
        if (interface_exists('\WebEd\Base\Pages\Repositories\Contracts\PageContract')) {
            \CustomFieldRules::registerRule('Basic', 'Page template', 'page_template', get_templates('Page'))
                ->registerRule('Basic', 'Page', 'page', function () {
                    $pageRepository = $this->app->make(\WebEd\Base\Pages\Repositories\Contracts\PageContract::class);
                    $pages = $pageRepository->all([
                        'order' => 'ASC',
                        'title' => 'ASC',
                    ], [
                        'id',
                        'title'
                    ], true);
                    $pageArray = [];
                    foreach ($pages as $row) {
                        $pageArray[$row->id] = $row->title;
                    }
                    return $pageArray;
                })
                ->registerRule('Other', 'Model name', 'model_name', [
                    'Page' => 'Page'
                ]);
        }
    }

    private function registerBlogFields()
    {
        if (
            interface_exists('\WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract') &&
            interface_exists('\WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract')
        ) {
            /**
             * Register blog group
             */
            \CustomFieldRules::registerRuleGroup('Blog')
                ->registerRule('Blog', 'Post template', 'blog.post_template', get_templates('Post'))
                ->registerRule('Blog', 'Category template', 'blog.category_template', get_templates('Category'))
                ->registerRule('Blog', 'Category', 'blog.category', function () {
                    $allCategories = get_categories();
                    $categories = collect_all_categories_to_one_array(categories_with_indent_text($allCategories));

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('Blog', 'Posts with related category', 'blog.post_with_related_category', function () {
                    $allCategories = get_categories();
                    $categories = collect_all_categories_to_one_array(categories_with_indent_text($allCategories));

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('Blog', 'Post with related category template', 'blog.post_with_related_category_template', get_templates('Category'))
                ->registerRule('Other', 'Model name', 'model_name', [
                    'blog.post' => '(Blog) Post',
                    'blog.category' => '(Blog) Category',
                ]);
        }
    }
}
