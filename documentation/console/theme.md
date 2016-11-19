#WebEd theme commands

####Disable themes
> php artisan theme:disable {alias}

####Enable themes
> php artisan theme:enable {alias}

####Install theme dependencies:
When you enable a theme, it's still not have some related things like database schema, sample data...,
it's time that you need to run install.

There are two ways to install theme:
> php artisan theme:install {alias}

or you go to **Admin Dashboard** page --> **Themes**. Then just click to **Install** button.

####Uninstall theme dependencies:
When you want to remove all installed dependencies of a theme like database schema...,
it's time that you need to run uninstall.
> php artisan theme:uninstall {alias}

or you go to **Admin Dashboard** page --> **Themes**. Then just click to **Uninstall** button.

##Generators

####Create a new theme
> php artisan theme:create {alias}

####Other helpers:
These commands will generate php files with specified type to the **current activated theme**.

> php artisan theme:make:controller {name} {--resource}

> php artisan theme:make:command {name}

> php artisan theme:make:provider {name}

> php artisan theme:make:view {name}

For example:

> php artisan theme:make:controller webed-blog SystemController --resource

> php artisan theme:make:provider webed-blog HookServiceProvider