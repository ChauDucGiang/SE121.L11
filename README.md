# Installation

Given below are the steps you need to follow, to install the VietNamHouseWarse Admin on your system:

-Nodejs 14 , PHP 7.*

### Step 1: Open the terminal in your root directory(VietNamHouseWarse Admin) & to install the composer packages run the following command:

`composer install `


### Step 2: In the root directory, copy .env setup.


`cp .env.test .env`


### Step 3: In the root directory, you will find a file named .env.example, rename the given file name to .env and run the following command to generate the key (and you can also edit your database credentials here).


`php artisan key:generate`

### Step 4: In the root directory, run the following command to generate the jwt key (and you can also edit your database credentials here).


`php artisan jwt:secret`

### Step 5: By running the following command, migrate and seed DB:


`php artisan migrate --seed`

### Step 6: By running the following command, you will be able to get all the dependencies in your node_modules folder:


`npm install`

### Step : To serve the application you need to run the following command in the project directory. (This will give you an address with port number 8000.) Now navigate to the given address you will see your application is running.


`php artisan serve`

### To change the port address, run the following command:


#### For port 8080
`php artisan serve --port=8080` 
#### If you want to run it on port 80, you probably need to sudo.
`sudo php artisan serve --port=80`


# Setup Vhost

### Change file /apache/conf/extra/httpd-vhosts.conf
` <VirtualHost *:80>`\
`    ServerAdmin webmaster@yourdomain.com`\
`    DocumentRoot "C:/xampp/htdocs/vietnamhouse/public"`\
`    ServerName  youdomain.com`\
`    ErrorLog "logs/yourdomain.com-error.log"`\
`    CustomLog "logs/yourdomain.com-access.log" common`\
`    <Directory "C:/xampp/htdocs/vietnamhouse/public">`\
`       Options FollowSymLinks`\
`        AllowOverride All`\
`        DirectoryIndex index.php`\
`        Require all granted`\
`    </Directory>`\
`</VirtualHost> `

### Set Domain : change file

`%windir%/system32/drivers/etc/hosts`
#### change : 127.0.0.1 yourdomain.com