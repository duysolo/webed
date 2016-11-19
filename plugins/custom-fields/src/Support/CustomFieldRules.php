<?php namespace WebEd\Plugins\CustomFields\Support;

class CustomFieldRules
{
    /**
     * @var string
     */
    protected $module = 'webed-custom-fields';

    /**
     * @var array
     */
    protected $ruleGroups = [];

    /**
     * @return $this
     */
    public function getInstance()
    {
        return $this;
    }

    /**
     * @param $groupName
     * @return $this
     */
    public function registerRuleGroup($groupName)
    {
        $this->ruleGroups[$groupName] = [
            'items' => []
        ];
        return $this;
    }

    /**
     * @param string $group
     * @param string $title
     * @param string $slug
     * @param \Closure|array $data
     * @return $this
     */
    public function registerRule($group, $title, $slug, $data)
    {
        if (!isset($this->ruleGroups[$group])) {
            $this->registerRuleGroup($group);
        }
        $this->ruleGroups[$group]['items'][$slug] = [
            'title' => $title,
            'slug' => $slug,
            'data' => (!isset($this->ruleGroups[$group]['items'][$slug])) ? $data : array_merge($this->ruleGroups[$group]['items'][$slug]['data'], $data)
        ];
        return $this;
    }

    /**
     * Render data
     * @return string
     */
    public function render()
    {
        return view($this->module.'::admin._script-templates.rules', [
            'ruleGroups' => $this->resolveGroups()
        ])->render();
    }

    /**
     * Resolve all rule data from closure into array
     * @return array
     */
    private function resolveGroups()
    {
        foreach ($this->ruleGroups as $groupKey => &$group) {
            foreach ($group['items'] as $type => &$item) {
                if ($item['data'] instanceof \Closure) {
                    $item['data'] = call_user_func($item['data']);
                }
                if (!is_array($item['data'])) {
                    $item['data'] = [];
                }
            }
        }
        return $this->ruleGroups;
    }
}
