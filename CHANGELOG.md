#Change log

##2.0.28 - 2017-01-19
- Check require related plugins when enable, install plugins, themes.
- Add some methods to check plugins version
- Refactor shortcode
- Add method removeItem() in DashboardMenu helper
- Refactor

##2.0.27 - 2017-01-16
- Base: 
    + Refactor the repositories
    + Add method pushModel()

##2.0.24 - 2017-01-13
- Base: 
    + Make WebEd Analytics as plugin.

##2.0.23 - 2017-01-13
- Base:
    + Add hook dashboard statistics
    + Add method count() to query builder
    + Remove debugbar. If you wanna use, add it by yourself
    + Add analytics
    + Move javascript plugins to **assets-management** repository
- Assets management:
    + Contains javascript plugins
    + Add morris, jvectormap
- Caching:
    + Add method count() to query builder
- Pages: 
    + Show dashboard statistics
- Modules management: 
    + Show dashboard statistics
    + Refactor
- Themes management: 
    + Show dashboard statistics
    + Refactor
- Users: 
    + Show dashboard statistics

##2.0.22 - 2017-01-12
- Pages: Allow user can change the routes of pages.
- Base: set default params for helper get_image

##2.0.21 - 2017-01-12
- Refactor the way to check ACL

##2.0.20 - 2017-01-12
- Add helper custom_strip_tags, limit_chars
- Refactor load themes, modules

##2.0.19 - 2017-01-11
- Refactor

##2.0.18 - 2017-01-08
- Refactor query builder

##2.0.17 - 2017-01-06
- Refactor datatable
- Add helper sort_item_with_children, flash_messages
- Refactor custom checkbox, custom radio
- Fix bugs cannot save menu when use cache

##2.0.16 - 2017-01-03
- Limit permissions to view admin menu items
- Modify before-edit hook
- Base:
    + Refactor admin js
    + Refactor label collective
- Caching:
    + Ignore cache when use eager loading

##2.0.15 - 2016-12-31
- Pages: 
    + Add CreatePageRequest
    + Fix bugs pages list cannot use group actions
    + Add PagesListDataTable to filter pages.index.get, datatables.pages.index.post
    + Rename EloquentPage to Page
- ACL
    + Add field created_by, updated_by, timestamps to table roles
    + Separate create and update roles into 2 method
    + Rename model EloquentPermission to Permission, EloquentRole to Role
    + Use form request to update/create roles
    + Save author and modifier when update/create roles
    + Rename RoleContract to RoleRepositoryContract, PermissionContract to PermissionRepositoryContract
    + Refactor
- Menus:
    + Separate create/update method      
    + Add target field
    + Use form request
    + Refactor
- Users:
    + Rename UserContract to UserRepositoryContract
    + Rename EloquentUser to User
    + Add form request
    + Use soft deletes
    + Refactor
- Base:
    + Add soft deletes to repositories
- Caching:
    + Add soft deletes repositories cache

##2.0.14 - 2016-12-27
- Refactor data table renderer.
- Add hook filter before edit, delete (pages, menus).

##2.0.13 - 2016-12-19
- Caching: remove magic method __call in AbstractRepositoryCacheDecorator

##2.0.13 - 2016-12-18
###Modify
- Add cors

##2.0.12 - 2016-12-18
###Modify
- Add class Constants to manage const
- Add SEO helper
- Add CKeditor to WebEd core js
- Refactor
- Remove unused files
- Add version
- Users: Add birthday, description, disabled_until to fillable
- Shortcode: Add helper generate_shortcode
- Caching: Add cache lifetime to env
- Pages: Fix bugs when create page, Pass seo data to front site
- ACL: Order permissions by namespace
- Refactor routes middleware


##2.0.11 - 2016-12-13
###Modify
- Travis CI test: cms:install
- phpunit.xml config
- Remove themes folder. Please get themes from [WebEd themes](https://github.com/webed-themes/readme)

##2.0.11 - 2016-12-12
###Added
- Travis CI test: cms:install
- Travis CI config
