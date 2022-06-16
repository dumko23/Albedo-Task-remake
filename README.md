# Albedo-Test-Task
Test task for Albedo trainee php-developer appointment

### Run it with Dicker-Compose

First, you should create a .env file according  ```sample.env.example``` file. 

Mysql credentials located both in ```docker-compose.yml``` and ```config.php``` files, so you might want to rewrite them. You SHOULD do it, especially, if you want to run this project in different environment (PDOAdapter.php refers to container name in HOST section).

To run the server use
```docker-compose up -d```.

Then execute ```InitDb.sql``` file in mysql to initialize DB and Table.

Then go to ```http://localhost/``` to enter project.

### To run with any other environment

```sample.env.example``` is located in project root folder. 

```config.php``` is located in ```/www/source```.

 You SHOULD change the credentials of DBHOST - ```PDOAdapter.php``` refers to container name in HOST section.
 
 Execute ```InitDb.sql``` file in mysql to initialize DB and Table.

