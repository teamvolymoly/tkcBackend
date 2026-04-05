#!/bin/bash

cd /home/kirayaca1/tkc.volymoly.com

git pull origin main

php artisan migrate --force

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
