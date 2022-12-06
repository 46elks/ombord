# Getting started

- Set up your web server with apache or nginx (see [server config](#server-config)).
- Set up an MySQL server and import the database dump located at `/api/onboard_*.sql`.
- Set your local project configuration (see [project config](#project-config)).

## Project config

There are two config files you need to change; one for the api and one for the app.

Create the file `api/config.php` and copy/paste the settings below. Set the values to match your setup:

```
define('DEBUG', false); # Set to true in development mode
define('SYSTEM_ADMIN_EMAIL', "admin@yourdomain.com");

# Database credentials
define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASS', "root");
define('DB_NAME', "ombord");
```

Create the file `app/config.php` and copy/paste the settings below. Set the values to match your setup:

```
define('DEBUG', false); # Set to true in development mode
define('SYSTEM_ADMIN_EMAIL', "admin@yourdomain.com");

# API URL
define('BASE_URL', "http://ombord.yourdomain.com");
define('BASE_URL_API', BASE_URL."/api/v1");

# Uploads
define('UPLOAD_URL', BASE_URL."/uploads"); // URL in browser
define('UPLOAD_PATH', ROOT.DS."uploads"); // Server path
```

## Server config

The directories `app` and `api` must be its own web roots.

In /docs you'll find example config for nginx and apache.