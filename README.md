

## Sistem Pengajuan Izin

To run this app, clone this repo and then run the following command in terminal:

 - Install the packages

```
composer install
```

 - Copy .env

```
cp .env.example .env
```
Then change `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`. Don't forget to create a new database.

 - Generate APP KEY

```
php artisan key:generate
```

 - Run the migrations
```
php artisan migrate
```
- Run the dev server
```
php artisan serve
```
