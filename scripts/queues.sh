#!/usr/bin/env bash

php artisan queue:work --queue=orders.jobs,orders.events,orders.notifications,orders.broadcasts,users,locations,products,keywords,default
