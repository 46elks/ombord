# Gettings started

- Set up an apache server and a MySQL server
- Import the database dump located at /api/ombord.sql
- Set your local config variables (see section 'config' below)

## Config

There are two config files you need to change; one for the api and one for the app.

Create the file `api/config.php` and copy/paste the settings below. Set the values to match your setup:

```
define('DB_HOST', "127.0.0.1");
define('DB_USER', "root");
define('DB_PASS', "root");
define('DB_NAME', "ombord");
define('BASE_URL', "http://api.ombord.local");
define('BASE_URL_API', BASE_URL."/v1");
define('DEBUG', true);
```

Create the file `app/config.php` and copy/paste the settings below. Set the values to match your setup:

```
define('BASE_URL', "http://ombord.local");
define('BASE_URL_API', "http://api.ombord.local/v1");
define('DEBUG', true);
```