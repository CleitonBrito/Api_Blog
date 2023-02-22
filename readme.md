# Laravel 9.19 REST APi
This API is created using Laravel 9.19 API Resource. It has Users, Posts and Comments. Protected routes are also added via JWT access token. In this project are used SOLID patthrn development. See the api documentation via Swagger.

#### Following are the Models
* User
* Post
* Comment
* UserCommentsVotes

#### Usage
Clone the project via git clone or download the zip file.

##### .env
Copy contents of .env.example file to .env file. Create a database and connect your database in .env file.
##### Composer Install
cd into the project directory via terminal and run the following  command to install composer packages.

```bash
composer install
```
##### Generate Key
then run the following command to generate fresh key.

```bash
php artisan key:generate
```
##### Run Migration
then run the following command to create migrations in the databbase.

```bash
php artisan migrate
```
##### Passport Install
run the following command to install Jwt key

```bash
php artisan jwt:secret
```
##### Database Seeding
finally run the following command to seed the database with dummy content.

```bash
php artisan db:seed
```
##### Initialize server
finally run the following command to seed the database with dummy content.

```bash
php artisan serve
```

### API EndPoints
* See `http://localhost:8000/api/doc`
