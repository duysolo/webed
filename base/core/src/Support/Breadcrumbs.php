<?php namespace WebEd\Base\Core\Support;

class Breadcrumbs
{

    /**
     * Links list
     * @var array
     */
    protected $links = [];

    /**
     * Breadcrumb class
     * @var string
     */
    protected $breadcrumbClass = 'breadcrumbs';

    /**
     * Container tag name
     * @var string
     */
    protected $containerTag = 'ul';

    /**
     * Item tag name
     * @var string
     */
    protected $itemTag = 'li';

    /**
     * Add link
     * @param string $title
     * @param string $link
     * @param null|string $icon
     */
    public function addLink($title, $link = null, $icon = null)
    {
        $this->links[] = $this->templateLink($title, $link, $icon);

        return $this;
    }

    /**
     * Get link template
     * @param string $title
     * @param string $link
     * @param null|string $icon
     * @return string
     */
    private function templateLink($title, $link = null, $icon = null)
    {
        if (!isset($link)) {
            return '<span>' . $icon . $title . '</span>';
        }
        return '<a title="' . $title . '" href="' . $link . '">' . $icon . $title . '</a>';
    }

    /**
     * Set breadcrumb class
     * @param string $class
     * @return $this
     */
    public function setBreadcrumbClass($class)
    {
        $this->breadcrumbClass = $class;

        return $this;
    }

    /**
     * Set container tag name
     * @param string $class
     * @return $this
     */
    public function setContainerTag($class)
    {
        $this->containerTag = $class;

        return $this;
    }

    /**
     * Set item tag name
     * @param string $class
     * @return $this
     */
    public function setItemTag($class)
    {
        $this->itemTag = $class;

        return $this;
    }

    /**
     * Render the breadcrumb
     * @return string
     */
    public function render()
    {
        $htmlSrc = '<' . $this->containerTag . ' class="' . $this->breadcrumbClass . '">';
        foreach ($this->links as $key => $row) {
            $htmlSrc .= '<' . $this->itemTag . '>' . $row . '</' . $this->itemTag . '>';
        }
        $htmlSrc .= '</' . $this->containerTag . '>';

        return $htmlSrc;
    }

    /**
     * Reset all value to default
     * @return $this
     */
    public function reset()
    {
        $this->links = [];
        $this->breadcrumbClass = 'breadcrumbs';
        $this->containerTag = 'ul';
        $this->itemTag = 'li';

        return $this;
    }
}
