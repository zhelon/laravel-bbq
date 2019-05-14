# laravel-bbq

1. Configurate your bd connection
2. Execute php artisan migrate to create the tables
3. Execute php artisan db:seed to seed your db with test data

APi endpoint:
http://127.0.0.1:8000/api/user/login/{email}/{password}
http://127.0.0.1:8000/api/user/get/{id}/{auth_token}

http://127.0.0.1:8000/api/publication/all/{auth_token}
http://127.0.0.1:8000/api/publication/get/{id}/{auth_token}
