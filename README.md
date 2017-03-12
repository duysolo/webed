# Welcome to WebEd - **Website Editor**
####A CMS based on Laravel 5.4
![Build status](https://travis-ci.org/sgsoft-studio/webed.svg)
![Total downloads](https://poser.pugx.org/sgsoft-studio/base/d/total.svg)
![Latest Stable Version](https://poser.pugx.org/sgsoft-studio/base/v/stable.svg)

##Demo & documentation
- [Documentation page](http://webed-docs.hitbui.com/docs/documentation.html)
- Demo site: [webed.hitbui.com](http://webed.hitbui.com)
- Admin demo site: [webed.hitbui.com/admincp](http://webed.hitbui.com/admincp) (demo/demo1234)

####WebEd is a free open source!

###Some cool features of WebEd CMS:
- Modular packages.
- Manage files with Elfinder.
- ACL.
- Menu management with drag & drop.
- Database caching.
- Themes & plugins management.
- Hook (actions hook, filters hook).
- Manage pages, blocks, blog, contact form, Google Analytics, custom fields...

##System Requirement
On this projects, I use the latest Laravel version (currently 5.4). 
Please go to [laravel documentation page](https://laravel.com/docs/5.4/installation) to check your system requirements.

##WebEd installation guide

####Method 1: Install directly
```
composer create-project --prefer-dist sgsoft-studio/webed webed
```

####Method 2: Add WebEd to your Laravel project
```
composer require sgsoft-studio/base:3.0.*
```
- Register the WebEd provider to **config/app.php**
```
WebEd\Base\Core\Providers\ModuleProvider::class,
```
- After that, remove the default Laravel migrations (create_users_table, create_password_resets_table)
- Modify the database information in **.env**

###Then
```
composer dump-autoload
php artisan cms:install
```

Access to dashboard:
> your-domain/admincp

You can config admin route by modify the .env:
```
WEBED_ADMIN_ROUTE=admincp
```

All available WebEd env config:
```
#Use for backup data
DB_DUMP_PATH=/Applications/AMPPS/mysql/bin/

#Caching service
CACHE_DRIVER=file
CACHE_REPOSITORY=true
CACHE_REPOSITORY_LIFETIME=-1

#Admin route alias
WEBED_ADMIN_ROUTE=admincp
WEBED_API_ROUTE=api
```

If you see this message when enable plugins/themes, it's because of your server does not support composer dump-autoload
helper. Try to run **composer dump-autoload** by yourself.


>The base module of this class is enabled, but class not found: ***xxx***. Please review and add the namespace of this module to composer autoload section, then run **composer dump-autoload**


##Plugins
Download the plugins and places it at **/plugins** folder.

[Plugins list](https://github.com/webed-plugins/readme)

##Themes
Download the themes and places it at **/themes** folder.

[Themes list](https://github.com/webed-themes/readme)

##Table of contents
- [WebEd module commands](./documentation/console/module.md)
- [WebEd theme commands](./documentation/console/theme.md)

##Need more support?
- Email: [duyphan.developer@gmail.com](mailto:duyphan.developer@gmail.com)
- Facebook: [Tedozi Manson](https://www.facebook.com/duyphan.developer)
- Skype: tedozi.manson

###I love github!

##Some screenshots
![Login](./documentation/images/1.png)
![Dashboard statistics](./documentation/images/2.png)
![Categories](./documentation/images/3.png)
![Menus](./documentation/images/4.png)
![Settings](./documentation/images/5.png)
