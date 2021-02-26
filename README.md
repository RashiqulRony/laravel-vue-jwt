###### .::  Laravel with VueJs JWT Token base CRUD Application  ::.

#### Downloading composer package and dumping
~~~bash
composer install
~~~

#### Downloading npm packages
~~~bash
npm install
~~~

### Copy code from `.env.example` to `.env` file

#### Configure project
~~~php
php artisan cache:clear
php artisan config:cache
php artisan key:generate
~~~

#### Storage folder link
~~~php
php artisan storage:link
~~~

### Create a database name and change credential in `.env` file

### migrate and seed database
~~~bash
php artisan migrate --seed
~~~


### Composer load now
~~~
composer dump-autoload
~~~


### Serving laravel project
~~~
php artisan serve
~~~


### Must be use project url:

~~~
Url: http://127.0.0.1:8000
~~~


