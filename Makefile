#/bin/sh
IP_ADDRESS:=$(ip addr show | grep "\binet\b.*\bdocker0\b" | awk '{print $2}' | cut -d '/' -f 1);
restart:
	docker-compose down;docker-compose up -d;
build:
	docker-compose build
initialize:
	cp ./.env.example ./.env
	docker-compose build
	docker-compose up --force-recreate -d
	sleep 5
	docker-compose run php bash -c "cd /code ; composer install ; php artisan key:generate"
	docker-compose run php bash -c "cd /code ;php artisan migrate:fresh --seed"

test :
	docker-compose run php bash -c "cd /code ;php artisan optimize:clear;php artisan migrate:fresh --database=sqlite;php artisan test"

test_without_docker :
	php artisan migrate:fresh --database=sqlite;
	php artisan test
