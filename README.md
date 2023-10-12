## Description

Horego Technical Test

Developed using [Laravel](https://laravel.com/docs/10.x/releases)

## Installation

_Kindly make sure [PHP ^8.2](https://www.php.net/releases/) and [Composer](https://getcomposer.org/) has been installed in the system_

## Dependencies
1. Install all the packages 
```bash
composer install
```
2. Make sure all the packages installed
3. If error occured during installation, refer to [Laravel Installation](https://laravel.com/docs/10.x/installation)

## Database
1. Create new Database in your local environment
```bash
CREATE DATABASE horego-test
```
2. Run the migration
```bash
php artisan migrate
```
2. Run seeder to create Default Users
```bash
php artisan db:seed
```

## Running the app
1. Run this in terminal (inside project folder)
```bash
php artisan serve
```
2. User Login
```bash
Super Admin
  - email: super.admin@gmail.com
  - pass: pass@admin

Account Manager
  - email: manager1@gmail.com
  - pass: pass@manager
```

## Thank you!
