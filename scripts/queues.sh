#!/usr/bin/env bash

php artisan queue:work --queue=users.jobs,users.events,locations.jobs,locations.events,orders.jobs,orders.events,orders.notifications,orders.broadcasts,companies.jobs,products.events,keywords.events,default
