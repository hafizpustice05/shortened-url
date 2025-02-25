#!/bin/bash

exec  docker-compose exec php /var/www/html/artisan $*