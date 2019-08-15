# UserLogger
API for storing user actions

INSTALLATION:
1. create in mysql database
2. composer install
3. cp .env.example .env and set configuration
4. php artisan key:generate
5. php artisan migrate
6. enjoy :)

API Endpoint's

POST /api/register 
body_params: nickname, firstname, lastname, age, password

POST /api/login 
body_params: nickname, password

POST /api/details  
headers: Authorization, "Bearer " . $token

POST /api/track/add  
headers: Authorization, "Bearer " . $token
body_params: source_label: action_name

TESTING:
run in terminal vendor/bin/phpunit 
