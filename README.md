<p align="center"><a href="https://www.prossodprokashon.com" target="_blank"><img src="https://www.prossodprokashon.com/logo.png" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Ecommerce Platform

This is a e-commerce platform I made mostly using Laravel ^8.3

| [Features][] | [Requirements][] | [Install][] | [How to setting][] | [License][] |

## Demo

<a target="_blank" href="https://www.prossodprokashon.com">Click here to visit live site</a>

## Features 
- Prossod prokashon is a complete E-Commerce platform .
- Implemented blog, product, cart, product review and order management system with php, laravel, mySQL and Vue js.
- A complete admin dashboard with frontend, products, blog, and order management. It has also a reporting system among monthly sales. A user is able to order a product, read a blog, comment on the blog, submit a review of a product.

## Madeby
- Laravel 8
- PHP 7.4
- Vuejs
- Vue store
- Bootstrap 5
- Javascript
- JQuery

## Requirements

	PHP = ^7.3|^8.0
    laravel-ui = ^3.2

## Install

Clone repo

```
git clone https://github.com/Md-shefat-masum/projonmo_laravel.git
```

Install Composer


[Download Composer](https://getcomposer.org/download/)


composer update/install 

```
composer install
```

Install Nodejs


[Download Node.js](https://nodejs.org/en/download/)


NPM dependencies
```
npm install
```

Using Laravel Mix 

```
npm run dev
```

## How to setting 

Go into .env file and change Database and Email credentials.

```
php artisan migrate
```

```
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=UserRoleSeeder
php artisan db:seed --class=DatabaseSeeder
```
	
Generating a New Application Key
```
php artisan key:generate
```


## License

> Copyright (C) 2021 Mdshefat.  
**[⬆ back to top](#laravel-ecommerce-platform)**

[Features]:#features
[Requirements]:#requirements
[Install]:#install
[How to setting]:#how-to-setting
[License]:#license
