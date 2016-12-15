# Codecast's Single Page Application Starter Kit

[![Build Status](https://travis-ci.org/codecasts/spa-starter-kit.svg?branch=develop)](https://travis-ci.org/codecasts/spa-starter-kit)

![Cover](http://vedovelli.com.br/spas.png)

> A **highly opinionated** Single Page Application starter kit built on top of Vue.js and Laravel.

This package contains two separate projects to act as a starting point for a Single Page Application: a Vue.js project (created with vue-cli + webpack template) and a Laravel 5.3 project.

They're not just freshly created projects but a fully working application that can be modified and expanded to become your own application.

## Demo

The live demo can be found in [https://spa.codecasts.rocks/](https://spa.codecasts.rocks/).

## Features

1. Client side
    * Vue.js 2.0 project create with vue-cli + webpack template
    * Centralized state management with Vuex
    * Route management with Vue-router
    * Authentication with JWT
    * Keep user signed in using local stored info
    * HTTP requests with [Axios](https://github.com/mzabriskie/axios)
    * ESLint with AirBNB preset
    * Pagination integrated with [Laravel's LengthAwarePaginator](https://laravel.com/docs/5.3/pagination#converting-results-to-json)
    * Alerts and Confirmation Alerts provided by [SweetAlert](http://t4t5.github.io/sweetalert/)
2. Server side
    * [Laravel 5.3](https://github.com/laravel/laravel/tree/v5.3.16)
    * Authentication with JWT
    * [Fractal](http://fractal.thephpleague.com/)
    * Web service RESTful with Dingo *(planned)*

## Prerequisites

Make sure you have installed **Node** and [**Yarn**](https://yarnpkg.com/) (latest versions) as well as **PHP 7** and **MySQL**.

## Installation

### Cloning

These commands will download the repository and prepare it for you.

```ssh
git clone --depth 1 -b master git@github.com:codecasts/spa-starter-kit.git
cd spa-starter-kit
rm -rf ./.git/
git init
git add --all
git commit -m "init"
```

### Setup

1. Client side - this is a Vue.js project created with vue-cli
	* With Terminal `cd client && yarn && yarn run dev`.
2. Server side - this is a Laravel 5.3 project
	* With Terminal:
        * Navigate to **webservice** folder and then:
        * `composer install` to install Laravel and third party packages
        * `touch database/database.sqlite` to create an empty database file
        * `cp .env.example .env` to configure installation
        * `php artisan key:generate` to generate unique key for the project
        * `php artisan jwt:secret` to generate unique key for the project
        * `php artisan migrate` to create all the tables
        * `php artisan db:seed` to fill the tables with fake data
        * `php artisan serve` to serve application on localhost:8000

## Usage

1. Client side
	* Your application will be available on **http://localhost:8080**
2. Server side
	* API endpoint is http://**localhost:8000/api**

## Testing

Navigate to **webservice** folder and run the composer test script

``` bash
$ composer test
```

## Things worth mentioning

1. Error handling is done globally by making use of Axios' interceptors. But you can still .catch() errors within components to perform actions related to that scope. See /client/src/plugins/http.js;

2. The same way error messages lives in one single component (/client/src/modules/general/alerts.vue) and their visibility is controlled by a Vuex property. So to show/hide messages it is just a matter of dispaching a Vuex action from within any component;

3. The spinner displayed during server requests (see top right close to user indentification) is also controlled by a Vuex property. The procedure to show/hide it is the same as outlined in the item 2 above;

4. routes and Vuex modules live close to the modules they work for. Always look for routes.js and store.js inside a module directory. See /client/src/modules/categories;

5. **Important**: Laravel project found in the directory *webservice* was modified beyond adding routes and controllers. For instance: the *webservice/app/Exceptions/Handler.php* was modified from its original version to return all exceptions to the client, not only HttpExceptions. Other changes are also in place. So our recommendation is to always use this project to build your own, instead of copying controllers and routes to a new project.

## Contributing

1. Fork it!
2. Create your feature branch from **develop**: `git checkout -b feature/my-new-feature`
3. Write your code. Comment your code.
4. Commit your changes: `git commit -am 'Add some feature'`
5. Push to the branch: `git push origin feature/my-new-feature`
6. Submit a pull request to **develop** branch :D

## Credits

[Fábio Vedovelli](https://github.com/vedovelli) and dedicated [contributors](https://github.com/codecasts/spa-starter-kit/graphs/contributors).

## License

Licensed under the MIT license.
