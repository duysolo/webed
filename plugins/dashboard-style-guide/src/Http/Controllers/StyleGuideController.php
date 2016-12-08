<?php namespace WebEd\Plugins\DashboardStyleGuide\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;

class StyleGuideController extends BaseAdminController
{
    protected $module = 'webed-dashboard-style-guide';

    protected $title = 'Style guide';

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addLink('Style guide', route('admin::dashboard-style-guide.index.get'));
    }

    public function getIndex()
    {
        $this->getDashboardMenu($this->module . '.index');

        $this->setPageTitle($this->title . ' - basic components');

        return $this->viewAdmin('index');
    }

    protected function page($title, $view)
    {
        $this->getDashboardMenu($this->module . '.' . $view);

        $this->setPageTitle($this->title . ' - ' . $title);

        return $this->viewAdmin($view);
    }

    public function getColors()
    {
        $this->dis['colors'] = [
            'white' => '#ffffff', 'default' => '#E1E5EC', 'dark' => '#2F353B', 'blue' => '#3598DC', 'blue-madison' => '#578EBE',
            'blue-chambray' => '#2C3E50', 'blue-ebonyclay' => '#22313F', 'blue-hoki' => '#67809F', 'blue-steel' => '#4B77BE', 'blue-soft' => '#4C87B9',
            'blue-dark' => '#5E738B', 'blue-sharp' => '#5C9BD1', 'blue-oleo' => '#94A0B2', 'green' => '#32C5D2', 'green-meadow' => '#1BBC9B',
            'green-seagreen' => '#1BA39C', 'green-turquoise' => '#36D7B7', 'green-haze' => '#44B6AE', 'green-jungle' => '#26C281', 'green-soft' => '#3FABA4',
            'green-dark' => '#4DB3A2', 'green-sharp' => '#2AB4C0', 'green-steel' => '#29B4B6', 'grey' => '#E5E5E5', 'grey-steel' => '#E9EDEF',
            'grey-cararra' => '#FAFAFA', 'grey-gallery' => '#555555', 'grey-cascade' => '#95A5A6', 'grey-silver' => '#BFBFBF', 'grey-salsa' => '#ACB5C3',
            'grey-salt' => '#BFCAD1', 'grey-mint' => '#525E64', 'red' => '#E7505A', 'red-pink' => '#E08283', 'red-sunglo' => '#E26A6A',
            'red-intense' => '#E35B5A', 'red-thunderbird' => '#D91E18', 'red-flamingo' => '#EF4836', 'red-soft' => '#D05454', 'red-haze' => '#F36A5A',
            'red-mint' => '#E43A45', 'yellow' => '#C49F47', 'yellow-gold' => '#E87E04', 'yellow-casablanca' => '#F2784B', 'yellow-crusta' => '#F3C200',
            'yellow-lemon' => '#F7CA18', 'yellow-saffron' => '#F4D03F', 'yellow-soft' => '#C8D046', 'yellow-haze' => '#C5BF66', 'yellow-mint' => '#C5B96B',
            'purple' => '#8E44AD', 'purple-plum' => '#8775A7', 'purple-medium' => '#BF55EC', 'purple-studio' => '#8E44AD', 'purple-wisteria' => '#9B59B6',
            'purple-seance' => '#9A12B3', 'purple-intense' => '#8775A7', 'purple-sharp' => '#796799', 'purple-soft' => '#8877A9',
        ];
        return $this->page('colors', 'colors');
    }

    public function getFontIcons()
    {
        return $this->page('font icons', 'font-icons');
    }
}
