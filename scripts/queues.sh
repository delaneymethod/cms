#!/usr/bin/env bash

php artisan queue:work --queue=users.jobs,locations.jobs,companies.jobs,orders.jobs,orders.events,orders.notifications,orders.broadcasts,users,locations,products,keywords,default
