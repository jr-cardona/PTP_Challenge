<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# Place to Pay Junior Challenge
Welcome! In this repository you can find the source code of the project based on a facturation system made with the Laravel 6 framework.

## Instructions for setup.
1. Install a server side application. Example: Xampp, Wamp, Lampp, Laragon, etc.
2. Clone the repository on the root. (htdocs for xampp, www for laragon and wamp, etc).
3. Open terminal and run the following commands:
<ul>
    <li>cd PTP_Challenge</li>
    <li>composer install</li>
    <li>npm install</li>
    <li>cp .env.example .env</li>
    <li>php artisan key:generate</li>
    <li>mysql -u root</li>
    <li>create database ptp_challenge;</li>
    <li>exit</li>
    <li>php artisan migrate --seed</li>
</ul>
4. To finish and deploy the application, run the command:
<br>
php artisan serve
<br>
5. Go to the generated link.
<br>
6. Register and Login.
