<p align="center">Crypto API Task</p>

##Requirements
- PHP 7.4 or Above
- Mysql 5.5 or Above

## Installation

- Clone the project to the directory you wish
- `cd [directory]`
- `composer install`
- `cp .env.example .env`.
- Update .env database section and set you credentials
- Update .env cache section and put redis/memcached credentials if you have, if no it will use you hard drive as cache storage.
- Run `php artisan key:generate` to generate new key for app.
- Run `php artisan jwt:generate` to generate new key for jwt auth.
- Run `php artisan migrate` to run a migrations
- Run `sudo -u [Your nginx or apache user, commonly www-data] php artisan serve` Most of cases your user will not have access to /tmp 
directory which is required for hosting laravel as itself without use of apache or nginx


## Versioning
Currently there is only one version supported [V1]
But all files and structure are done for supporting more versions
V1, V2, V3 folders, route files and middleware for switching betweem the is created.

## Auth
We have used JWT Auth [https://github.com/tymondesigns/jwt-auth] for authenitcating users

## Routes
- POST `/api/v1/auth/register`
- POST `/api/v1/auth/login`

- GET `/api/v1/exchange/coins`
- GET `/api/v1/exchange/ticker/{id}`

## Note
Do not forget to put `Accept: application/json` in request headers, to tell our api that you are requesting json responses..

## PS
Thanks and regards, coded with love by Rob :)
