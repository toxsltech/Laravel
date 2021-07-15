# #Aery
## About Project
The main objective of this project is to create a platform (Web App) that empowers the travel community to easily share their travel experiences. Users will have the ability to create their experiences, discover new experiences published by fellow travellers and save the experiences they find interesting to their own map


## Installation

* Step 1: Place the complete project on the live server

* Step 2: Run command `composer install --prefer-dist`

* Step 3: rename .env-example to .env

* Step 4: Run command `php artisan key:generate`

* Step 5: open .env file and update project credentials
	APP_URL: YOUR_DOMAIN
	DB_DATABASE=YOUR_DB_NAME
	DB_USERNAME=YOUR_DB_USERNAME
	DB_PASSWORD=YOUR_DB_PASSWORD
* Create database with `DB_DATABASE` name in database.
* Step 6: Run command `php artisan migrate`. It will create empty database with all tables for you.


##STEPS TO SETUP PROJECT  link** : **YOUR_DOMAIN**
* Step 1: Register admin first.
* Step 2 : Login with admin creadantial.
* Step 3 : Set authorization registration age for user in Age Section. 

##Login to your admin and you can manage everything from admin panel.

Now, check all the permissions to the folder before finishing up.
644 permissions should be to all the files
755 permissions should be to all the folders
Good to go!!!


