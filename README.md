# 25098. Test Assignment for Laravel _ Frontend 


# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


Clone the repository

    git clone git@gitlab.gitesoft.com:test-assignments-v2/25098-test-assignment-for-laravel-_-frontend.git

Switch to the repo folder

    cd 25098-test-assignment-for-laravel-_-frontend

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file (database connection details)

    cp .env.example .env


Generate a new application key

    php artisan key:generate
    

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Populate the database with seed data with relationships which includes users, hotels, rooms, bookings, etc

    php artisan db:seed

Start the local development server

    php artisan serve --port=8000

You can now access the server at http://localhost:8000

## Login details

 An admin user was created with the following credentials:
 
  - email: **admin@codeline.com**
  - password: **password**
    
## Database seeding


***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:fresh

# Testing API

To test the laravel backend api 

    vendor/bin/phpunit    

Or if you have phpuit installed globally

    phpunit

----------

# Code overview

