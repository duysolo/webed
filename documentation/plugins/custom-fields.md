#How to use Custom Fields plugin

####Active this plugin
Go through to **Admin Dashboard** --> **Plugins** --> Enable and install this plugin.
Currently, this plugin support **Pages** and **Blog**.

####View how to use it:
On WebEd version 2, we supported repeater inside repeater.
[Youtube](https://www.youtube.com/watch?v=4Mlo4iCR_rw&feature=youtu.be)

####Available methods:

**get_field**: get a custom field from a model
```
    function get_field(BaseModelContract $object, $alias = null): string|mixed|null
```

Example:
```
    $page = Page:find(1);
    $field = get_field($page, 'foo');
```

**has_field**: determine a model has custom field or not
```
    function has_field(BaseModelContract $object, $alias = null): bool
```

Example:
```
    $page = Page:find(1);
    $hasField = has_field($page, 'foo');
```

**get_sub_field**: get a repeater field from a parent field with the specified alias
```
    $page = Page:find(1);
    foreach(get_field($page, 'foo_repeater') as $item) {
        $childField = get_sub_field($item, 'bar');
    }
```

**has_sub_field**: determine the parent field has sub field with the specified alias
```
    $page = Page:find(1);
    foreach(get_field($page, 'foo_repeater') as $item) {
        $hasBar = has_sub_field($item, 'bar');
    }
```
