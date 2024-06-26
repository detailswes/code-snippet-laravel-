## The Laravel snippets   


This Laravel snippet has included the auth, users, and roles crud operations.

### Auth 

* User Login
* User Register 
* Forgot Password 


### User

* Create User
* Edit User
* Delete User
* View User


### Roles   

* Create Role and assign permissions 
* Edit Role and update permissions 
* Delete Role 

## Requirements

* Laravel 9
* PHP 8 +

## Common setup

1. Take clone from git by using the below command.
    1. `git clone https://github.com/digvijaysingh100/code-snippet-laravel.git`
    2. `cd code-snippet-laravel`
    3. `git branch`
2. Install docker and docker compose
3. From the root of the project
   ` Run : docker-compose up -d --build`
4. Add this file under this path : nginx\conf\app.conf
   Add this data in this file :
    ```sh
    server {
    listen 80;
    index index.php index.html;
    error_log /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/public;
    client_max_body_size 100M;
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
    }
    
5. `sudo docker exec nginx nginx -s reload`
6. Check docker container
   `docker-compose ps `
7. Create .env file in root directory and make changes according to credential.
8. Run command inside the docker container
    1. `docker exec -it laravel_snippet /bin/bash (app is container, You need to run this command then run all command that is below)`
    2. `composer install`
    3. `composer require doctrine/dbal`
    4. `php artisan migrate`
    5. `php artisan db:seed`
    6. `php artisan storage:link`
