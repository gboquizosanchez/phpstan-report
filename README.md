# PHPStan Report

[![Latest Stable Version](https://poser.pugx.org/gboquizosanchez/phpstan-report/version.svg)](https://packagist.org/packages/gboquizosanchez/phpstan-report)
[![License](https://poser.pugx.org/gboquizosanchez/phpstan-report/license.svg)](https://packagist.org/packages/gboquizosanchez/phpstan-report)
[![Downloads](https://poser.pugx.org/gboquizosanchez/phpstan-report/d/total.svg)](https://packagist.org/packages/gboquizosanchez/phpstan-report)

## Overview

PHPStan Report is a Laravel package that provides an elegant web interface for viewing, analyzing, and managing PHPStan static analysis results. Transform your code quality insights into an interactive, user-friendly dashboard.

## Features ✨

- **🎯 Dynamic Level Control** - Adjust PHPStan analysis levels (1-10) through an intuitive web interface
- **⚡ Real-time Analysis** - Execute PHPStan analysis directly from your browser
- **📊 Beautiful Reports** - View detailed analysis results with clear, organized presentation
- **🌓 Theme Support** - Switch between dark and light themes with session persistence
- **📋 Copy Functionality** - One-click copy for error messages and solutions
- **📱 Responsive Design** - Optimized experience across mobile and desktop devices
- **🚀 Composer Integration** - Seamless integration with Composer scripts
- **💾 Auto-save Settings** - Automatically remembers your preferred configuration

## Requirements

- **PHP**: 8.3+
- **Laravel**: 11.0+ or 12.0+
- **Composer**: Latest stable version

# Installation

Install the package via Composer:

```bash
composer require gboquizo/phpstan-report
```

## Quick Setup

Run the installation command to automatically configure PHPStan Report:

```bash
php artisan install:phpstan-report
```

This command performs the following actions:
1. **Creates `phpstan.neon`** - Generates a configuration file with level 3 analysis (if not exists)
2. **Publishes assets** - Copies package assets to `public/vendor/phpstan-report`
3. **Updates `composer.json`** - Adds PHPStan script for easy execution
4. **Runs initial analysis** - Executes PHPStan analysis and asset discovery

### Generated Configuration
The installation creates a basic `phpstan.neon` configuration:

```neon
parameters:
    level: 3
    paths:
        - app
```

You can customize this configuration according to your project needs.


## Screenshots 💄

![Panel](https://raw.githubusercontent.com/gboquizosanchez/phpstan-report/refs/heads/main/arts/panel.jpg)

## Usage
### Accessing the Web Interface
Navigate to the PHPStan Report dashboard using any of these methods:
- **Direct URL**: `https://your-application.com/phpstan-report`
- **Artisan route list**: Use `php artisan route:list --name=phpstan` to verify the route

### Dashboard Features
#### 📊 Analysis Dashboard
- **Real-time statistics** showing total errors, warnings, and analysis status
- **File-based organization** with expandable error lists
- **Severity indicators** with color-coded error types

#### ⚙️ Level Management
- **Interactive slider** to adjust PHPStan analysis levels (1-10)
- **Instant feedback** showing level descriptions and expected behavior
- **Automatic re-analysis** when level changes are applied

#### 🚀 Analysis Execution
- **One-click analysis** button for immediate code scanning
- **Progress indicators** showing analysis status
- **Success/error notifications** with detailed feedback

#### 🎨 User Experience
- **Theme toggle** between dark and light modes
- **Persistent preferences** saved across browser sessions
- **Mobile-optimized** interface for analysis on-the-go
- **Copy-to-clipboard** functionality for quick error sharing

### Command Line Usage
You can also run PHPStan analysis through Composer:

``` bash
# Run analysis (added by installation command)
composer phpstan-report
```

### Getting Help
If you encounter issues:
1. **Check the logs** - Laravel logs may contain helpful error messages
2. **Verify requirements** - Ensure PHP and Laravel versions meet minimum requirements
3. **Clear cache** - Run `php artisan config:clear` and `php artisan cache:clear`
4. **Open an issue** - [Report bugs or request features](https://github.com/gboquizosanchez/phpstan-report/issues/new)

## Contributing
We welcome contributions! Please feel free to:
- 🐛 **Report bugs** through GitHub issues
- 💡 **Suggest features** or improvements
- 🔧 **Submit pull requests** with bug fixes or enhancements
- 📖 **Improve documentation** or add examples

## Credits 🧑‍💻

- **Author**: [Germán Boquizo Sánchez](mailto:germanboquizosanchez@gmail.com)
- **Built with**: [PHPStan](https://phpstan.org/) - The powerful PHP static analysis tool
- **Framework**: [Laravel](https://laravel.com/) - The PHP framework
- **Contributors**: [View all contributors](../../contributors)

## License
This package is open-source software licensed under the [MIT License](LICENSE.md).

## Dependencies

### PHP dependencies 📦
- Illuminate Console [![Latest Stable Version](https://img.shields.io/badge/stable-v12.21.0-blue)](https://packagist.org/packages/illuminate/console)
- Illuminate Http [![Latest Stable Version](https://img.shields.io/badge/stable-v12.21.0-blue)](https://packagist.org/packages/illuminate/http)
- Illuminate Support [![Latest Stable Version](https://img.shields.io/badge/stable-v12.21.0-blue)](https://packagist.org/packages/illuminate/support)
- Illuminate View [![Latest Stable Version](https://img.shields.io/badge/stable-v12.21.0-blue)](https://packagist.org/packages/illuminate/view)
- Phpstan Phpstan [![Latest Stable Version](https://img.shields.io/badge/stable-2.1.21-blue)](https://packagist.org/packages/phpstan/phpstan)

#### Develop dependencies 🔧
- Hermes Dependencies [![Latest Stable Version](https://img.shields.io/badge/stable-1.2.0-blue)](https://packagist.org/packages/hermes/dependencies)
- Laravel Pint [![Latest Stable Version](https://img.shields.io/badge/stable-v1.24.0-blue)](https://packagist.org/packages/laravel/pint)

#### Develop dependencies 🔧
- Alpinejs [![Latest Stable Version](https://img.shields.io/badge/stable-3.14.9-blue)](https://www.npmjs.com/package/alpinejs)
- Autoprefixer [![Latest Stable Version](https://img.shields.io/badge/stable-10.4.20-blue)](https://www.npmjs.com/package/autoprefixer)
- Postcss [![Latest Stable Version](https://img.shields.io/badge/stable-8.4.49-blue)](https://www.npmjs.com/package/postcss)
- Tailwindcss [![Latest Stable Version](https://img.shields.io/badge/stable-3.4.16-blue)](https://www.npmjs.com/package/tailwindcss)
- Vite [![Latest Stable Version](https://img.shields.io/badge/stable-7.0-blue)](https://www.npmjs.com/package/vite)

**Made with ❤️ for the PHP community**
