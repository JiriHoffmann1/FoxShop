Hello and thank you for downloading my application. In this file, I will explain how to run the application on your computer.

## Installation
1) Open command line in an empty folder on your computer and run the following command: "git clone https://github.com/JiriHoffmann1/FoxShop"
2) Open the project in your editor of choice and run "composer install" and "npm install" commands in the terminal window (This might take a while)
3) In the root folder, find a file called "env.example" and rename it to ".env"
4) Open .env file and fill in your database credentials

After you complete all those steps, the application is set up and ready to be used.

## Running the application
1) Turn on your local server and MySQL database (I personally use XAMPP)
2) In the terminal window, run the following command: "php artisan serve"
3) On the first run of the application, run the following command: "php artisan migrate" to create the database 
4) Now you can make requests to this application using your localhost address.

## Recommendations
1) I recommend using Postman or similar program to make requests to this application.
2) If needed, overwrite the "accept" parameter in the request headers to "application/json". This is done to make sure that the response is in JSON format. 
    - Without this step, laravel might be returning HTML responses to failed request validations (422 responses).
    
## Enjoy!    

Author: Jiří Hoffmann
