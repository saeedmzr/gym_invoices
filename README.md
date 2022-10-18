## Introduction

This is simple product for managing your clubs.
User can have memberships,and can check-in at your clubs as a membership or guest.
This product will manage user check-in monthly invoices.

## Installation

There's 2 method for installation of this product. First one is using docker.



If you intend to do use docker for installation,you have 2 choices:



#### First,you can use :  `docker-compose up`

After that,you got 3 containers in your docker.

Go to php container with `docker exec -it <container name> bash`

Run `cp .env.example .env` to create env file of product.

Run `php artisan key:generate` to generate a app key

Run `php artisan test` to run test cases.

Run `php artisan migrate` to migrate your migration classes.

Run `php artisan db:seed` to seed your db.

Run `php artisan admin:create` to create a new admin.note that you can change admin credentials in env file as well.

Run `php artisan serve`

import `virtuagym.json` from root directory file in your postman to access to webservices of product


#### To simplify commands that you have to run in your container i made a `Makefile`.It located in root directory.
`MakeFile` contains 4 methods:

`make build` : build container

`make restart` : down then up container again

`make initialize` : initilize container and do some docker-compose commands

`make test` : running tests then,run server for you

`make test_without_docker` : running tests in your local machine using sqlite db





##### Second method for installation is said step by step below.

1 - install composer packages in root directory with this command: `composer install`

2 -Create a copy of `.env.example` to `.env` , Create Database ,config it in `.env` file

3 - Change admin credentials if you want to ,in `.env` file and setup your DB connection in  `.env` .

4 - Test first! migrate in sqlite : `PHP artisan migrate:fresh --database=sqlite`

5 - Run test cases with : `PHP artisan test`

6 - After that,you should see 15 successful tests pass.Now,you should migrate in your main DB: `PHP artisan migrate`


7 - Seed your DB : `PHP artisan db:seed`

8 - Create an admin with this command : `PHP artisan admin:create` (You can change admin credentials in .env file)

9 - run : `PHP artisan serve` and access to product in http://localhost:8000/

### Documentation 

there's a documentation in `/virtuagym_doc` in root directory that you can see the documentation.

### Collection for webservices

There's a collection `virtuagym.json` in root directory.
