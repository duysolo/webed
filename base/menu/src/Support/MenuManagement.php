<?php namespace WebEd\Base\Menu\Support;

class MenuManagement
{
    /**
     * @var array
     */
    protected $widgetBoxes = [];

    /**
     * @var array
     */
    protected $objectInfoByType = [];

    /**
     * @param string $title
     * @param string $type
     * @param \Closure|array $data
     * @return $this
     */
    public function registerWidget($title, $type, $data)
    {
        $this->widgetBoxes[] = [
            'title' => $title,
            'type' => $type,
            'data' => $data,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getWidgets()
    {
        $widgets = $this->widgetBoxes;

        $result = [];

        /**
         * Resolve the data
         */
        foreach ($widgets as $widget) {
            $data = array_get($widget, 'data');
            if ($data instanceof \Closure) {
                $widget['data'] = call_user_func($data);
            }
            if (!is_array($widget['data']) || !$widget['data']) {
                continue;
            }
            $result[] = view('webed-menu::admin._components.widget', [
                'type' => $widget['type'],
                'title' => $widget['title'],
                'data' => $widget['data'],
            ])->render();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function renderWidgets()
    {
        $widgets = $this->getWidgets();
        $result = '';
        foreach ($widgets as $widget) {
            $result .= $widget;
        }
        return $result;
    }

    /**
     * @param $type
     * @param \Closure $callback
     * @return $this
     */
    public function registerLinkType($type, \Closure $callback)
    {
        $this->objectInfoByType[$type] = $callback;
        return $this;
    }

    /**
     * @param $type
     * @param array ...$params
     * @return array|null
     */
    public function getObjectInfoByType($type, ...$params)
    {
        if(!array_get($this->objectInfoByType, $type)) {
            return null;
        }
        $result = call_user_func_array($this->objectInfoByType[$type], $params);

        return (array)$result;
    }
}
