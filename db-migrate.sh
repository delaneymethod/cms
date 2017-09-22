#!/usr/bin/env bash

clear 

php artisan down --message="Upgrading Database" --retry=60

php artisan migrate:fresh --seed

php artisan up
