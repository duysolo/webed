<?php namespace WebEd\Plugins\CustomFields\Hook\Actions\Render;

use WebEd\Base\Core\Models\Contracts\BaseModelContract;
use WebEd\Base\Core\Models\EloquentBase;
use WebEd\Base\Users\Models\EloquentUser;

abstract class AbstractRenderer
{
    public function __construct()
    {
        /**
         * @var EloquentUser $loggedInUser
         */
        $loggedInUser = auth()->user();

        $roles = [];
        foreach ($loggedInUser->roles()->select('id')->get() as $role) {
            $roles[] = $role->id;
        }

        /**
         * Every models will have these rules by default
         */
        add_custom_field_rules([
            'logged_in_user' => $loggedInUser->id,
            'logged_in_user_has_role' => $roles
        ]);
    }

    /**
     * @param string $type
     * @param EloquentBase $item
     */
    public function render($type, BaseModelContract $item)
    {
        $customFieldBoxes = get_custom_field_boxes($item, $item->id);

        $view = view('webed-custom-fields::admin.custom-fields-boxes-renderer', [
            'customFieldBoxes' => json_encode($customFieldBoxes),
        ])->render();

        echo $view;
    }
}
