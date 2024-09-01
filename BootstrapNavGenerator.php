<?php

class BootstrapNavGenerator {
    private $menuItems = [];
    private $brandName = '';
    private $brandUrl = '#';
    private $brandImage = '';
    private $theme = 'light';
    private $fixed = '';
    private $containerClass = 'container-fluid';
    private $navbarClass = 'navbar-expand-lg';
    private $searchForm = false;
    private $customClasses = [];
    private $activePath;

    public function __construct() {
        $this->setActivePath();
    }

    public function setBrand($name, $url = '#', $image = '') {
        $this->brandName = $name;
        $this->brandUrl = $url;
        $this->brandImage = $image;
    }

    public function setTheme($theme) {
        if (!in_array($theme, ['light', 'dark'])) {
            trigger_error("Invalid theme '{$theme}'. Defaulting to 'light'.", E_USER_WARNING);
            $theme = 'light';
        }
        $this->theme = $theme;
    }

    public function setFixed($position) {
        $validPositions = ['top', 'bottom'];
        if (!in_array($position, $validPositions)) {
            trigger_error("Invalid fixed position '{$position}'. Navbar will not be fixed.", E_USER_WARNING);
            $position = '';
        }
        $this->fixed = $position;
    }

    public function setContainer($type) {
        $validTypes = ['fluid', 'sm', 'md', 'lg', 'xl', 'xxl'];
        $this->containerClass = in_array($type, $validTypes) ? "container-{$type}" : 'container-fluid';
    }

    public function setExpandPoint($breakpoint) {
        $validBreakpoints = ['sm', 'md', 'lg', 'xl', 'xxl'];
        $this->navbarClass = in_array($breakpoint, $validBreakpoints) ? "navbar-expand-{$breakpoint}" : 'navbar-expand-lg';
    }

    public function addMenuItem($label, $url, $submenu = [], $icon = '', $customClass = '') {
        $this->menuItems[] = [
            'label' => $label,
            'url' => $url,
            'submenu' => $submenu,
            'icon' => $icon,
            'customClass' => $customClass
        ];
    }

    public function addSearchForm($placeholder = 'Search', $buttonText = 'Search') {
        $this->searchForm = [
            'placeholder' => $placeholder,
            'buttonText' => $buttonText
        ];
    }

    public function addCustomClass($class) {
        $this->customClasses[] = $class;
    }

    public function generateMenu() {
        $navbarClasses = [
            'navbar',
            $this->navbarClass,
            "navbar-{$this->theme}",
            "bg-{$this->theme}",
            $this->fixed ? "fixed-{$this->fixed}" : '',
            ...$this->customClasses
        ];

        $html = '<nav class="' . implode(' ', array_filter($navbarClasses)) . '">
            <div class="' . $this->containerClass . '">
                ' . $this->generateBrand() . '
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        ' . $this->generateMenuItems() . '
                    </ul>
                    ' . $this->generateSearchForm() . '
                </div>
            </div>
        </nav>';

        return $html;
    }

    public function setActivePath($path = null) {
        if ($path === null) {
            // Automatically detect the current URL
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }
        $this->activePath = $path;
    }

    private function isActive($url) {
        return $this->activePath === $url ||
            ($url !== '/' && strpos($this->activePath, $url) === 0);
    }

    private function generateBrand() {
        if (empty($this->brandName) && empty($this->brandImage)) {
            return '';
        }

        $brandContent = '';
        if (!empty($this->brandImage)) {
            $brandContent .= '<img src="' . htmlspecialchars($this->brandImage) . '" alt="' . htmlspecialchars($this->brandName) . '" height="30" class="d-inline-block align-top me-2">';
        }
        $brandContent .= htmlspecialchars($this->brandName);

        return '<a class="navbar-brand" href="' . htmlspecialchars($this->brandUrl) . '">' . $brandContent . '</a>';
    }

    private function generateMenuItems($items = null) {
        $html = '';
        $items = $items ?? $this->menuItems;

        foreach ($items as $item) {
            if (empty($item['submenu'])) {
                $html .= $this->generateMenuItem($item);
            } else {
                $html .= $this->generateDropdownItem($item);
            }
        }

        return $html;
    }

    private function generateMenuItem($item) {
        $icon = !empty($item['icon']) ? '<i class="' . htmlspecialchars($item['icon']) . ' me-1"></i>' : '';
        $customClass = !empty($item['customClass']) ? ' ' . htmlspecialchars($item['customClass']) : '';
        $activeClass = $this->isActive($item['url']) ? ' active' : '';

        return '<li class="nav-item' . $customClass . '">
            <a class="nav-link' . $activeClass . '" href="' . htmlspecialchars($item['url']) . '">' . $icon . htmlspecialchars($item['label']) . '</a>
        </li>';
    }

    private function generateDropdownItem($item) {
        $icon = !empty($item['icon']) ? '<i class="' . htmlspecialchars($item['icon']) . ' me-1"></i>' : '';
        $customClass = !empty($item['customClass']) ? ' ' . htmlspecialchars($item['customClass']) : '';
        $activeClass = $this->isActive($item['url']) ? ' active' : '';

        $html = '<li class="nav-item dropdown' . $customClass . '">
            <a class="nav-link dropdown-toggle' . $activeClass . '" href="#" id="navbarDropdown' . htmlspecialchars($item['label']) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ' . $icon . htmlspecialchars($item['label']) . '
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown' . htmlspecialchars($item['label']) . '">';

        foreach ($item['submenu'] as $subitem) {
            if (isset($subitem['submenu'])) {
                $html .= $this->generateMultiLevelDropdownItem($subitem);
            } else {
                $subicon = !empty($subitem['icon']) ? '<i class="' . htmlspecialchars($subitem['icon']) . ' me-1"></i>' : '';
                $subActiveClass = $this->isActive($subitem['url']) ? ' active' : '';
                $html .= '<li><a class="dropdown-item' . $subActiveClass . '" href="' . htmlspecialchars($subitem['url']) . '">' . $subicon . htmlspecialchars($subitem['label']) . '</a></li>';
            }
        }

        $html .= '</ul>
        </li>';

        return $html;
    }

    private function generateMultiLevelDropdownItem($item) {
        $icon = !empty($item['icon']) ? '<i class="' . htmlspecialchars($item['icon']) . ' me-1"></i>' : '';
        $html = '<li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ' . $icon . htmlspecialchars($item['label']) . '
            </a>
            <ul class="dropdown-menu">';

        foreach ($item['submenu'] as $subitem) {
            if (isset($subitem['submenu'])) {
                $html .= $this->generateMultiLevelDropdownItem($subitem);
            } else {
                $subicon = !empty($subitem['icon']) ? '<i class="' . htmlspecialchars($subitem['icon']) . ' me-1"></i>' : '';
                $subActiveClass = $this->isActive($subitem['url']) ? ' active' : '';
                $html .= '<li><a class="dropdown-item' . $subActiveClass . '" href="' . htmlspecialchars($subitem['url']) . '">' . $subicon . htmlspecialchars($subitem['label']) . '</a></li>';
            }
        }

        $html .= '</ul>
        </li>';

        return $html;
    }

    private function generateSearchForm() {
        if (!$this->searchForm) {
            return '';
        }

        return '<form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="' . htmlspecialchars($this->searchForm['placeholder']) . '" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">' . htmlspecialchars($this->searchForm['buttonText']) . '</button>
        </form>';
    }
}
