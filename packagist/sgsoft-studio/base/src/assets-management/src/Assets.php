<?php namespace WebEd\Base\AssetsManagement;

class Assets
{
    /**
     * @var array
     */
    protected $js = [];

    /**
     * @var array
     */
    protected $css = [];

    /**
     * @var array
     */
    protected $fonts = [];

    /**
     * @var int|mixed
     */
    protected $version;

    /**
     * Render assets with version of application
     * @var bool
     */
    protected $withVersion = false;

    /**
     * @var string
     */
    protected $getFrom;

    protected $appendedJs = [
        'top' => [],
        'bottom' => [],
    ];

    protected $appendedCss = [];

    /**
     * @author sangnm <sang.nguyenminh@elinext.com>
     */
    public function __construct()
    {
        if (config('app.env') == 'production') {
            $version = config('webed.version', 2.0);
        } else {
            $version = time();
        }
        $this->version = $version;
    }

    /**
     * @param string $environment
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function getAssetsFrom($environment = 'admin')
    {
        $this->getFrom = $environment;

        $this->js = config('assets.default.' . $environment . '.js');
        $this->css = config('assets.default.' . $environment . '.css');
        $this->fonts = config('assets.default.' . $environment . '.fonts');

        return $this;
    }

    /**
     * @param bool $bool
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function withVersion($bool = true)
    {
        $this->withVersion = (bool)$bool;

        return $this;
    }

    /**
     * Add javascripts to current module
     *
     * @param array|string $assets
     * @author sangnm <sang.nguyenminh@elinext.com>
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function addJavascripts($assets)
    {
        $this->js = array_unique(array_merge($this->js, (array)$assets));

        return $this;
    }

    /**
     * Add stylesheets to current module
     *
     * @param array|string $assets
     * @author sangnm <sang.nguyenminh@elinext.com>
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function addStylesheets($assets)
    {
        $this->css = array_unique(array_merge($this->css, (array)$assets));

        return $this;
    }

    /**
     * Add fonts to current module
     *
     * @param array|string $assets
     * @author sangnm <sang.nguyenminh@elinext.com>
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function addFonts($assets)
    {
        $this->fonts = array_unique(array_merge($this->fonts, (array)$assets));

        return $this;
    }

    /**
     * @param $assets
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function addStylesheetsDirectly($assets)
    {
        if (!is_array($assets)) {
            $assets = func_get_args();
        }
        $this->appendedCss = array_merge($this->appendedCss, $assets);

        return $this;
    }

    /**
     * @param $assets
     * @param string $location
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function addJavascriptsDirectly($assets, $location = 'bottom')
    {
        $js = array_merge((array)$assets, $this->appendedJs[$location]);
        $this->appendedJs[$location] = $js;

        return $this;
    }

    /**
     * Remove Css to current module
     *
     * @param array|string $assets
     * @author sangnm <sang.nguyenminh@elinext.com>
     * @modify Tedozi Manson <duyphan.developer@gmail.com>
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function removeStylesheets($assets)
    {
        foreach ((array)$assets as $rem) {
            unset($this->css[array_search($rem, $this->css)]);
        }
        return $this;
    }

    /**
     * Remove Javascript to current module
     *
     * @param array|string $assets
     * @author sangnm <sang.nguyenminh@elinext.com>
     * @modify Tedozi Manson <duyphan.developer@gmail.com>
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function removeJavascripts($assets)
    {
        foreach ((array)$assets as $rem) {
            unset($this->js[array_search($rem, $this->js)]);
        }
        return $this;
    }

    /**
     * @param $replace
     * @param $with
     * @param string|array $type
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    public function replace($replace, $with, $type = 'js')
    {
        if (is_array($type)) {
            foreach (array_unique($type) as $row) {
                $this->replace($replace, $with, $row);
            }
        }
        switch ($type) {
            case 'css':
                $this->css[array_search($replace, $this->css)] = $with;
                break;
            case 'fonts':
                $this->fonts[array_search($replace, $this->fonts)] = $with;
                break;
            case 'js':
                $this->js[array_search($replace, $this->js)] = $with;
                break;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function renderStylesheets()
    {
        $data = '';
        $version = '';
        if ($this->withVersion) {
            $version .= '?' . $this->version;
        }
        foreach ($this->fonts as $row) {
            foreach ($this->getResourceUrls(array_get(config('assets.resources.fonts', []), $row)) as $resource) {
                $data .= PHP_EOL . '<link rel="stylesheet" type="text/css" href="' . $resource . $version . '"/>';
            }
        }
        foreach ($this->css as $row) {
            foreach ($this->getResourceUrls(array_get(config('assets.resources.css', []), $row)) as $resource) {
                $data .= PHP_EOL . '<link rel="stylesheet" type="text/css" href="' . $resource . $version . '"/>';
            }
        }
        foreach ($this->appendedCss as $row) {
            $data .= PHP_EOL . '<link rel="stylesheet" type="text/css" href="' . $row . $version . '"/>';
        }
        return $data;
    }

    /**
     * @param $location
     * @return string
     */
    public function renderScripts($location)
    {
        $data = '';
        $version = '';
        if ($this->withVersion) {
            $version .= '?' . $this->version;
        }
        foreach ($this->js as $row) {
            foreach ($this->getResourceUrls(array_get(config('assets.resources.js', []), $row), $location) as $resource) {
                $data .= PHP_EOL . '<script type="text/javascript" src="' . $resource . $version . '"></script>';
            }
        }
        if (isset($this->appendedJs[$location])) {
            foreach ($this->appendedJs[$location] as $row) {
                $data .= PHP_EOL . '<script type="text/javascript" src="' . $row . $version . '"></script>';
            }
        }
        return $data;
    }

    /**
     * @param array $resources
     * @param null $location
     * @return array
     */
    protected function getResourceUrls(array $resources, $location = null)
    {
        $isUseCdn = (config('assets.always_use_local')) ? false : (array_get($resources, 'use_cdn', false));
        if ($isUseCdn) {
            $data = (array)array_get($resources, 'src.cdn');
        } else {
            $data = (array)array_get($resources, 'src.local');
        }

        if (!$location) {
            return $data;
        }

        /**
         * Check matched location
         */
        if (array_get($resources, 'location') === $location) {
            return $data;
        }
        return [];
    }

    /**
     * Determine when an asset loaded
     * @param string $assetName
     * @param string $type
     * @return bool
     */
    public function assetLoaded($assetName, $type)
    {
        if (in_array($assetName, $this->$type)) {
            return true;
        }
        return false;
    }
}
