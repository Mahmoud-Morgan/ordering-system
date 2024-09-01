## Overview

ordering system, That allows users to place an orders, update the ingredients stock and notify the merchants before the ingredients run out.

## Technologies

### Back-End

- **[PHP 8.2]**
- **[Laravel 11]**

### Database

- **[MySQL]**

## Installation


> Download Project

``` bash
git clone git@github.com:Mahmoud-Morgan/ordering-system.git
```

> Install Composer Packages

``` bash
composer install
```
> Create MySQL database file for the application
```
choose database name yourself
```
> Migrate & Seed Database

``` bash
php artisan migrate --seed
```

> Generate Key

``` bash
php artisan key:generate
```

> Run On Local Machine

``` bash
php artisan test
```
``` bash
php artisan serve
```

## API Endpoints

The following API endpoints are available in the application:

| Method | URL | Response |
| ------ | --- | -------- |
| POST   | /api/orders             | Create a new order     
