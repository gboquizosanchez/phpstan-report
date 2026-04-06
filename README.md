<div align="center">

<img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f4ca.svg" width="100" alt="PHPStan Report">

# `gboquizosanchez/phpstan-report`

**A beautiful web interface for PHPStan results in Laravel**

[![Latest Stable Version](https://img.shields.io/packagist/v/gboquizosanchez/phpstan-report.svg)](https://packagist.org/packages/gboquizosanchez/phpstan-report)
[![Total Downloads](https://img.shields.io/packagist/dt/gboquizosanchez/phpstan-report.svg)](https://packagist.org/packages/gboquizosanchez/phpstan-report)
[![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4?logo=php&logoColor=white)](https://packagist.org/packages/gboquizosanchez/phpstan-report)
[![Laravel](https://img.shields.io/badge/Laravel-11%20%7C%2012-FF2D20?logo=laravel&logoColor=white)](https://packagist.org/packages/gboquizosanchez/phpstan-report)
[![License: MIT](https://img.shields.io/badge/License-MIT-22C55E.svg)](LICENSE.md)

---

*Stop squinting at terminal output. Run PHPStan, browse results, fix errors — all from your browser.*

</div>

---

## Overview

PHPStan Report is a Laravel package that provides an elegant web interface for viewing, analyzing, and managing PHPStan static analysis results. Transform your code quality insights into an interactive, user-friendly dashboard.

[![Panel](https://raw.githubusercontent.com/gboquizosanchez/phpstan-report/refs/heads/1.x/arts/panel.jpg)](https://raw.githubusercontent.com/gboquizosanchez/phpstan-report/refs/heads/1.x/arts/panel.jpg)

---

## ✨ Features

- 🎯 **Dynamic Level Control** — Adjust PHPStan analysis levels (1–10) from the UI
- ⚡ **Real-time Analysis** — Run PHPStan directly from your browser
- 📊 **Beautiful Reports** — Errors grouped by file, expandable inline, with severity indicators
- 🌓 **Dark / Light theme** — Persisted per session
- 📋 **One-click copy** — Copy error messages and suggested fixes instantly
- 📱 **Responsive** — Optimized for mobile and desktop
- 🚀 **Composer integration** — Seamless integration with Composer scripts
- 💾 **Auto-save** — Remembers your preferred configuration

---

## Requirements

- PHP 8.3+
- Laravel 11.0+ or 12.0+

> [!WARNING]
> This package is intended for **development environments only**. Do not install it in production.

---

## 📦 Installation

```bash
composer require gboquizosanchez/phpstan-report
```

Run the installation command to automatically configure everything:

```bash
php artisan install:phpstan-report
```

This command will:

1. **Create `phpstan.neon`** — Generates a base config at level 3 (if not already present)
2. **Publish assets** — Copies assets to `public/vendor/phpstan-report`
3. **Update `composer.json`** — Adds a `phpstan-report` Composer script
4. **Run initial analysis** — Executes PHPStan and discovers your codebase

### Generated `phpstan.neon`

```neon
parameters:
    level: 3
    paths:
        - app
```

You can customize this file to match your project's needs.

---

## 🚀 Usage

Navigate to the dashboard in your browser:

```
https://your-application.com/phpstan-report
```

Or verify the route is registered:

```bash
php artisan route:list --name=phpstan
```

You can also trigger analysis from the command line:

```bash
composer phpstan-report
```

### Dashboard features

**Analysis overview** — Real-time stats showing total errors, warnings, and current analysis status.

**Level management** — Interactive slider to adjust PHPStan levels (1–10) with instant feedback and automatic re-analysis on change.

**Error browser** — File-based organization with expandable error lists, color-coded severity, and one-click copy for quick sharing.

**Theme & preferences** — Toggle between dark and light mode; settings persist across sessions.

---

## Troubleshooting

1. **Check the logs** — Laravel logs may contain helpful error messages.
2. **Verify requirements** — Ensure PHP and Laravel versions meet the minimum requirements.
3. **Clear cache** — Run `php artisan config:clear` and `php artisan cache:clear`.
4. **Open an issue** — [Report bugs or request features](https://github.com/gboquizosanchez/phpstan-report/issues/new).

---

## Contributing

Contributions are welcome!

- 🐛 **Report bugs** via [GitHub Issues](https://github.com/gboquizosanchez/phpstan-report/issues/new)
- 💡 **Suggest features** or improvements
- 🔧 **Submit pull requests** with fixes or enhancements
- 📖 **Improve documentation** or add examples

---

## Credits

- **Author**: [Germán Boquizo Sánchez](mailto:germanboquizosanchez@gmail.com)
- **Built with**: [PHPStan](https://phpstan.org/) · [Laravel](https://laravel.com/) · [Alpine.js](https://alpinejs.dev/) · [Tailwind CSS](https://tailwindcss.com/)
- **Contributors**: [View all contributors](https://github.com/gboquizosanchez/phpstan-report/contributors)

---

## 📄 License

This package is open-source software licensed under the [MIT License](LICENSE.md).

---

<div align="center">

Made with ❤️ for the PHP community

</div>
