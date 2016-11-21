<?php namespace WebEd\Base\Settings\Support;

use Illuminate\Support\Collection;
use WebEd\Base\Settings\Repositories\Contracts\SettingContract;

class CmsSettings
{
    /**
     * @var array
     */
    private $groups = [
        'basic' => [
            'title' => 'Basic',
            'piority' => 1,
            'items' => [],
        ],
        'advanced' => [
            'title' => 'Advanced',
            'piority' => 2,
            'items' => [],
        ],
    ];

    /**
     * @var array
     */
    private $settings;

    public function __construct()
    {

    }

    /**
     * @return array
     */
    public function getSettingFromDB()
    {
        $setting = app(SettingContract::class);
        $this->settings = $setting->getAllSettings();

        return $this->settings;
    }

    /**
     * @param string $groupKey
     * @param string $groupTitle
     * @return $this
     */
    public function addGroup($groupKey, $groupTitle, $piority = 999)
    {
        if (!isset($this->groups[$groupKey])) {
            $this->groups[$groupKey] = [
                'title' => $groupTitle,
                'piority' => $piority,
                'items' => [],
            ];
        }

        return $this;
    }

    public function getGroup()
    {
        return $this->groups;
    }

    /**
     * @param $groupKey
     * @param array $options
     * @return $this
     */
    public function modifyGroup($groupKey, $options = [])
    {
        if (isset($options['items'])) {
            unset($options['items']);
        }
        $this->groups[$groupKey] = array_merge($this->groups[$groupKey], $options);

        return $this;
    }

    /**
     * @param $name
     * @param $options
     * @param \Closure $htmlHelpersParams
     * @return $this
     */
    public function addSettingField($name, $options, \Closure $htmlHelpersParams)
    {
        $options = array_merge([
            'group' => 'basic',
            'type' => null,
            'piority' => 999,
            'label' => null,
            'helper' => null,
        ], $options);

        if (array_get($this->groups, $options['group']) === null) {
            $options['group'] = 'basic';
        }

        $this->groups[$options['group']]['items'][] = [
            'name' => $name,
            'type' => $options['type'],
            'piority' => $options['piority'],
            'params' => $htmlHelpersParams,
            'label' => array_get($options, 'label'),
            'helper' => array_get($options, 'helper'),
        ];

        return $this;
    }

    /**
     * @return Collection
     */
    public function export()
    {
        $settingGroup = collect($this->groups)->sortBy('piority')->toArray();

        foreach ($settingGroup as $key => $group) {
            $settingGroup[$key]['items'] = collect($group['items'])->sortBy('piority')->toArray();
        }

        return collect($settingGroup);
    }

    /**
     * @param null $key
     * @param null $default
     * @return array|string
     */
    public function getSetting($key = null, $default = null)
    {
        if($this->settings === null) {
            $this->settings = $this->getSettingFromDB();
        }

        if ($key === null) {
            return $this->settings;
        }

        return array_get($this->settings, $key, (string)$default);
    }
}
