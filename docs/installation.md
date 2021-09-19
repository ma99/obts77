## setup
```
$ clone
$ .env (copy)
$ run the following to avoid 500 error
(after pulling a git project.)
	php artisan key:generate

After creating .env file and generating the key, run the code below:

	php artisan cache:clear 
	php artisan config:clear

$ create a database i.e obts77_db
$ php artisan migrate 
$ php artisan db:seed

$ php artisan storage:links

```