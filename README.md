How to run?
Go to https://github.com/VegeGrinder/DemoBoostOrder to clone/download repository
Unzip project into your XAMPP directory “./xampp/htdocs”, which becomes “./xampp/htdocs/DemoBoostOrder/…”
1) Open XAMPP
2) Run Apache & MySQL in XAMPP
3) Go to phpMyAdmin -> create database “demoboostorder”
4) Go to Laravel project root directory -> ./xampp/htdocs/DemoBoostOrder
5) Run “composer install”
6) Run “php artisan key:generate”
7) Run “php artisan migrate”
8) Run “php artisan db:seed –class=CreateUsersSeeder”
9) Run “php artisan serve”
10) Go to “127.0.0.1:8000”
