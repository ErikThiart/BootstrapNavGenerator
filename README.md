# Bootstrap 5 Navigation Menu Generator

## Table of Contents
1. [Introduction](#introduction)
2. [Features](#features)
3. [Requirements](#requirements)
4. [Installation](#installation)
5. [Usage](#usage)
6. [Configuration Options](#configuration-options)
7. [Examples](#examples)
8. [Customization](#customization)
9. [Contributing](#contributing)
10. [License](#license)

## Introduction

The Bootstrap 5 Navigation Menu Generator is a PHP class that simplifies the process of creating dynamic, responsive navigation menus for websites using Bootstrap 5. It provides a flexible and easy-to-use interface for generating customizable navigation bars with support for dropdown menus, search forms, and active item highlighting.

## Features

- Dynamic generation of Bootstrap 5 compatible navigation menus
- Support for dropdown menus (multi-level)
- Customizable brand/logo section
- Light and dark theme options
- Fixed positioning (top or bottom)
- Responsive design with customizable breakpoints
- Search form integration
- Icon support (compatible with Bootstrap Icons or other icon libraries)
- Dynamic active item highlighting based on current URL
- Custom CSS class support for additional styling

## Requirements

- PHP 7.0 or higher
- Bootstrap 5 CSS and JS files
- (Optional) Bootstrap Icons or another icon library for menu item icons

## Installation

1. Download the `BootstrapNavGenerator.php` file.
2. Place it in your project directory where you keep your PHP classes.
3. Include the file in your PHP script:

```php
require_once 'path/to/BootstrapNavGenerator.php';
```

## Usage

Here's a basic example of how to use the Bootstrap 5 Navigation Menu Generator:

```php
<?php
require_once 'BootstrapNavGenerator.php';

$nav = new BootstrapNavGenerator();
$nav->setBrand('My Website', '/');
$nav->addMenuItem('Home', '/');
$nav->addMenuItem('About', '/about');
$nav->addMenuItem('Services', '/services', [
    ['label' => 'Web Design', 'url' => '/services/web-design'],
    ['label' => 'SEO', 'url' => '/services/seo']
]);
$nav->addMenuItem('Contact', '/contact');

echo $nav->generateMenu();
?>
```

## Configuration Options

### Setting the Brand
```php
$nav->setBrand('My Website', '/', 'path/to/logo.png');
```

### Changing the Theme
```php
$nav->setTheme('dark'); // or 'light'
```

### Fixed Positioning
```php
$nav->setFixed('top'); // or 'bottom'
```

### Container Type
```php
$nav->setContainer('lg'); // 'fluid', 'sm', 'md', 'lg', 'xl', 'xxl'
```

### Expansion Breakpoint
```php
$nav->setExpandPoint('md'); // 'sm', 'md', 'lg', 'xl', 'xxl'
```

### Adding a Search Form
```php
$nav->addSearchForm('Search our site...');
```

### Adding Custom Classes
```php
$nav->addCustomClass('my-custom-navbar');
```

## Examples

### Full Example with All Features

```php
<?php
require_once 'BootstrapNavGenerator.php';

$nav = new BootstrapNavGenerator();
$nav->setBrand('My Website', '/', 'path/to/logo.png');
$nav->setTheme('dark');
$nav->setFixed('top');
$nav->setContainer('lg');
$nav->setExpandPoint('md');
$nav->addMenuItem('Home', '/', [], 'bi bi-house');
$nav->addMenuItem('About', '/about', [], 'bi bi-info-circle');
$nav->addMenuItem('Services', '/services', [
    ['label' => 'Web Design', 'url' => '/services/web-design', 'icon' => 'bi bi-brush'],
    ['label' => 'SEO', 'url' => '/services/seo', 'icon' => 'bi bi-search']
], 'bi bi-gear');
$nav->addMenuItem('Contact', '/contact', [], 'bi bi-envelope');
$nav->addSearchForm('Search our site...');
$nav->addCustomClass('custom-navbar');

echo $nav->generateMenu();
?>
```

## Customization

You can further customize the navigation menu by extending the `BootstrapNavGenerator` class or by modifying the existing methods to suit your specific needs.

## Contributing

Contributions to improve the Bootstrap 5 Navigation Menu Generator are welcome. Here's how you can contribute:

1. **Reporting Issues**: If you find a bug or have a suggestion for improvement, please open an issue in the GitHub repository. Provide as much detail as possible, including steps to reproduce the issue if applicable.

2. **Submitting Pull Requests**: If you'd like to contribute code:
   - Fork the repository
   - Create a new branch for your feature or bug fix
   - Make your changes
   - Submit a pull request with a clear description of the changes

3. **Improving Documentation**: If you notice areas where the documentation could be improved or expanded, feel free to suggest changes.

4. **Sharing Ideas**: If you have ideas for new features or improvements, open an issue to discuss them.

Before making significant changes, it's a good idea to open an issue to discuss the proposed changes with the maintainers.

Please ensure that your contributions adhere to:
- The existing code style
- Best practices for PHP and Bootstrap 5
- Proper documentation of new features or changes

By contributing to this project, you acknowledge that your contributions will be released under The Unlicense, effectively placing them in the public domain.

Thank you for helping to improve the Bootstrap 5 Navigation Menu Generator!

## License

This project is licensed under The Unlicense - see the [UNLICENSE](UNLICENSE) file for details.

This means that you are free to do whatever you want with this software. You can use it, modify it, distribute it, or sell it without any restrictions. The authors have released it into the public domain, dedicating all their rights to the work to the public domain worldwide.

For more information about The Unlicense, visit [https://choosealicense.com/licenses/unlicense/](https://choosealicense.com/licenses/unlicense/).

---

For more information or support, please open an issue in the GitHub repository.
