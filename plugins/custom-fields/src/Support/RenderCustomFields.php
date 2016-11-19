<?php namespace WebEd\Plugins\CustomFields\Support;

use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldGroupContract;

class RenderCustomFields
{
    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * @var \WebEd\Plugins\CustomFields\Repositories\FieldGroupRepository
     */
    protected $fieldGroupRepository;

    /**
     * @var array|string
     */
    protected $rules = [];

    public function __construct()
    {
        $this->app = app();
        $this->fieldGroupRepository = $this->app->make(FieldGroupContract::class);
    }

    /**
     * @param array|string $rules
     * @return $this
     */
    public function setRules($rules)
    {
        if (!is_array($rules)) {
            $this->rules = json_decode($rules, true);
        } else {
            $this->rules = $rules;
        }
        return $this;
    }

    /**
     * @param string|array $ruleName
     * @param $value
     * @return $this
     */
    public function addRules($ruleName, $value = null)
    {
        if (is_array($ruleName)) {
            $rules = $ruleName;
        } else {
            $rules = [$ruleName => $value];
        }
        $this->rules = array_merge($this->rules, $rules);

        return $this;
    }

    private function checkRules($ruleGroups)
    {
        if (!$ruleGroups) {
            return false;
        }
        //dd($this->rules, $ruleGroups);
        foreach ($ruleGroups as $group) {
            if ($this->checkEachRule($group)) {
                return true;
            }
        }
        return false;
    }

    private function checkEachRule($ruleGroup)
    {
        $result = false;
        foreach ($ruleGroup as $rule) {
            if (!isset($this->rules[$rule['name']])) {
                continue;
            }
            if ($rule['type'] == '==') {
                if(is_array($this->rules[$rule['name']])) {
                    if(in_array($rule['value'], $this->rules[$rule['name']])) {
                        $result = true;
                    } else {
                        $result = false;
                    }
                } else {
                    if ($rule['value'] == $this->rules[$rule['name']]) {
                        $result = true;
                    } else {
                        $result = false;
                    }
                }
            } else {
                if(is_array($this->rules[$rule['name']])) {
                    if(!in_array($rule['value'], $this->rules[$rule['name']])) {
                        $result = true;
                    } else {
                        $result = false;
                    }
                } else {
                    if ($rule['value'] != $this->rules[$rule['name']]) {
                        $result = true;
                    } else {
                        $result = false;
                    }
                }
            }
            if (!$result) {
                return false;
            }
        }
        return $result;
    }

    /**
     * @param $morphClass
     * @param $morphId
     * @return array
     */
    public function exportCustomFieldsData($morphClass, $morphId)
    {
        $fieldGroups = $this->fieldGroupRepository
            ->where([
                'status' => 'activated'
            ])
            ->orderBy('status', 'ASC')
            ->get();

        $result = [];

        foreach ($fieldGroups as $row) {
            if ($this->checkRules(json_decode($row->rules, true))) {
                $result[] = [
                    'id' => $row->id,
                    'title' => $row->title,
                    'items' => $this->fieldGroupRepository->getFieldGroupItems($row->id, null, true, $morphClass, $morphId),
                ];
            }
        }

        return $result;
    }
}
