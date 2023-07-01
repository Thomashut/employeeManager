# employeeManager
A simple Laravel application to manage and display employee records and record their status/departments.

# First time run
To setup the application first ensure your mysql database is up and running.
Enter the application directory and run `php artisan migrate`. Ensure that the .env file is present in the application directory
If the tables have been created successfully you can seed the database with `php artisan db:seed`
To run the application first install php dependencies with `composer install`
Then start the localhost server with `php artisan serve`
Then install the Vite dependencies with `npm i`
Then run the frontend package server with `npm run dev`