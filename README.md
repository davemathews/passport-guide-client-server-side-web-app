## Passport Guide Part II - Server Side Web App Example

This is an example application for [Part II of the Passport guide series](https://mattallan.me/posts/passport-guide-server-side-web-app-clients).

Either follow along with the guide to build your own application, or if you would prefer to use this client as a starting point, follow the setup steps below.

## Setup

1. Clone the repo.

```
git clone git@github.com:matt-allan/passport-guide-client-server-side-web-app.git
cd passport-guide-client-server-side-web-app
```

2. Install dependencies.

```
composer install
```

3. Copy the example .env file.

```
cp .env.example .env
```

4. Generate an app key.

```
php artisan key:generate --ansi
```

5. Create the database. If you prefer a different database use the client of your choice and update the .env file accordingly.

```
mysql -u root -e 'create database passport_client_server'
```

6. Run the migrations.

```
php artisan migrate
```

7. Setup the domain. If using something besides Valet such as Homestead consult the docs.

```
valet link server-app
```

8. Create a passport client and add your client credentials to the .env file. You can create a client by navigating to [http://passport.test/home](http://passport.test/home) and clicking the 'Create New Client' button. You will need to set `PASSPORT_CLIENT_ID` and `PASSPORT_CLIENT_SECRET`.