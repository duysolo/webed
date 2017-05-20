# Welcome to WebEd CMS
#### A CMS based on Laravel 5.4
![Build status](https://travis-ci.org/sgsoft-studio/webed.svg)
![Total downloads](https://poser.pugx.org/sgsoft-studio/base/d/total.svg)
![Latest Stable Version](https://poser.pugx.org/sgsoft-studio/base/v/stable.svg)

## Demo
- Demo site: [https://newstv.sgsoft-studio.com/](https://newstv.sgsoft-studio.com/)
- Admin demo site: [https://newstv.sgsoft-studio.com/admincp](https://newstv.sgsoft-studio.com/admincp) (demo/demo1234)

### Documentation
- [Documentation page](https://webed.sgsoft-studio.com/docs/3.1/overview)
- Link repos documentation: [github.com/sgsoft-studio/docs-site](https://github.com/sgsoft-studio/docs-site)

#### WebEd is a free open source!

### Donate
If you interested in and wanna help me on WebEd development.

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.me/duyphan2502)

### Some cool features of WebEd CMS:
- Modular packages.
- Manage files with Elfinder.
- ACL.
- Menu management with drag & drop.
- Database caching.
- Themes & plugins management.
- Hook (actions hook, filters hook).
- Manage pages, blocks, blog, contact form, Google Analytics, custom fields...

## System Requirement
On this projects, I use the latest Laravel version (currently 5.4). 
Please go to [laravel documentation page](https://laravel.com/docs/5.4/installation) to check your system requirements.

## WebEd installation guide

```
composer create-project --prefer-dist sgsoft-studio/webed webed
```

### Then
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


## Plugins
Download the plugins and places it at **/plugins** folder.

[Plugins list](https://github.com/webed-plugins)
All plugins with released version is `3.1.*` will stable with WebEd 3.1.

## Need more support?
- Email: [duyphan.developer@gmail.com](mailto:duyphan.developer@gmail.com)
- Facebook: [Tedozi Manson](https://www.facebook.com/duyphan.developer)
- Skype: tedozi.manson
