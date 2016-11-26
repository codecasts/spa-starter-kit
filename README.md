# Codecast's SPA Starter Kit

> A **highly opinionated** Single Page Application starter kit built on top of Vue.js and Laravel.

This package contains two separate projects to act as a starting point for a Single Page Application: a Vue.js project (created with vue-cli + webpack template) and a Laravel 5.3 project.

They're not just freshly created projects but a fully working application that can be modified and expanded to become your own application.

## Features

1. Client side
    * Vue.js 2.0 project create with vue-cli + webpack template
    * Centralized state management with Vuex
    * Route management with Vue-router
    * Authentication with JWT
    * Keep user signed in using local stored info
    * HTTP requests with Axios
    * ESList, no semi-colons
    * Pagination integrated with Laravel's LengthAwarePaginator
2. Server side
    * Laravel 5.3
    * Authentication with JWT
    * Web service RESTful with Dingo *(planned)*

## Prerequisites

Make sure you have installed **Node** and **NPM** (latest versions) as well as **PHP 7** and **MySQL**.

## Installation

1. Client side
	* With Terminal `cd client && npm i && npm run dev`. Alternatively you can use Yarn: `cd client && yarn && npm run dev`. More info here: [https://yarnpkg.com/](https://yarnpkg.com/).
2. Server side
	* With Terminal:
        * Navigate to **webservice** folder and then:
        * `composer install` to install Laravel and third party packages
        * `touch database/database.sqlite` to create an empty database file
        * `cp .env.example .env` to configure installation
        * `php artisan migrate` to create all the tables
        * `php artisan db:seed` to fill the tables with fake data
        * `php artisan serve` to serve application on localhost:8000

## Usage

1. Client side
	* Your application will be available on **http://localhost:8080**
2. Server side
	* API endpoint is http://**localhost:8000/api**

## Things worth mentioning

1. Error handling is done globally by making use of Axios' interceptors. But you can still .catch() errors within components to perform actions related to that scope. See /client/src/plugins/http.js;

2. The same way error messages lives in one single component (/client/src/modules/general/alerts.vue) and their visibility is controlled by a Vuex property. So to show/hide messages it is just a matter of dispaching a Vuex action from within any component;

3. The spinner displayed during server requests (see top right close to user indentification) is also controlled by a Vuex property. The procedure to show/hide it is the same as outlined in the item 2 above;

4. routes and Vuex modules live close to the modules they work for. Always look for routes.js and store.js inside a module directory. See /client/src/modules/categories.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## Credits

[Fábio Vedovelli](https://github.com/vedovelli)

## License

Licensed under the MIT license.