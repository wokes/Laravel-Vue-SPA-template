[![CircleCI](https://circleci.com/gh/wokes/Laravel-Vue-SPA-template.svg?style=svg&circle-token=298f67655b97cd0e8034777d031d50c11cc707f6)](https://circleci.com/gh/wokes/Laravel-Vue-SPA-template)

# Laravel-Vue-SPA-template
A template for Single Page Application built with Laravel and Vue.

# Installation
```
Set up your .env file

composer install
npm install
npm run dev

php artisan migrate
php artisan key:generate
php artisan passport:install

php artisan serve    <- see 'Worth noting' below
```

## Features included out of the box:
- CircleCI configuration
- Token auth powered by Laravel Passport
- Vue.js frontend with Vuex and Vue Router, utilizing auth API endpoints for registration, login and retrieval of currently logged in user 

## Worth noting
- User IDs are UUIDs instead of integers
- Laravel is configured so that web server accesses base directory, not `/public`. To run it locally with `php artisan serve`, copy `index.php` in base directory and rename it to `server.php`.
- Frontend can be accessed at `localhost:8000/app`
