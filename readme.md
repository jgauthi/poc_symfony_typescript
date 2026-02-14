# POC Symfony
## Prerequisites

* The PHP version must be greater than or equal to PHP 8.4
* The SQLite 3 extension must be enabled
* The JSON extension must be enabled
* The Ctype extension must be enabled
* The date.timezone parameter must be defined in php.ini
* Yarn command line

More information on [symfony website](https://symfony.com/doc/7.4/reference/requirements.html).

## Features developed
[Symfony Vite](https://symfony-vite.pentatrion.com) is a tool to facilitate the development experience of modern web projects. It provides: a development server which allows, among other things, Hot Module Replacement 🔥 of generated code by taking advantage of ES modules, a build command which uses Rollup.

[TypeScript](https://www.typescriptlang.org) is a strongly typed programming language that builds on JavaScript, giving you better tooling at any scale.

You can look at previous releases v1.3 for [Webpack encore version](https://github.com/jgauthi/poc_symfony_typescript/tree/v1.3).


## Installation
Command lines:

```bash
# clone current repot
composer install

# (optional) Copy and edit configuration values ".env.local"

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate -n

# Optional
php bin/console doctrine:fixtures:load -n

# Installation Assets
npm install
npm run dev
#npm run build # for production
```

For the asset symlink install, launch a terminal on administrator in windows environment.

## Usage
Just execute this command to run the built-in web server _(require [symfony installer](https://symfony.com/download))_ and access the application in your browser at <http://localhost:8000>:

```bash
# Dev env
symfony server:start

# Test env
APP_ENV=test php -d variables_order=EGPCS -S 127.0.0.1:8000 -t public/
```

Alternatively, you can [configure a web server](https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html) like Nginx or Apache to run the application.

Your commit is checked by several dev tools (like phpstan, php cs fixer...). These tools were managed by [Grumphp](https://github.com/phpro/grumphp), you can edit configuration on file [grumphp.yml](./grumphp.yml) or check manually with the command: `./vendor/bin/grumphp run`.