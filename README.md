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
    * Create a database and configure connection by changing Laravel's provided .env file. Then...
	* With Terminal:
        * `cd webservice`
        * `composer install`
        * `php artisan migrate`
        * `php artisan db:seed`
        * `php artisan serve`

## Usage

1. Client side
	* Your application will be available on **http://localhost:8080**
2. Server side
	* API endpoint is http://**localhost:8000/api**

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