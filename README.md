**Laravel Version: 11.0**

**PHP Version: 8.1+**

**Database: MySQL**


**Postman documentation added to project main directory as .sql file**

**DB schema added to project main directory as .sql file**

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations and seeds (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve
