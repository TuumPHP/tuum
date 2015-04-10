TuumPHP Starter Repository
======

A starter repository for TuumPHP web site. 

### License

MIT lisense.

Getting Started
----

### system requirements

This repository requires PHP >= 5.6.0. 

### installation

use ```git``` and ```composer``` to install. 

```sh
git clone https://github.com/TuumPHP/tuum
cd tuum
composer install
cd public
php -S localhost:8888 index.php
```

and access ```http://localhost:8888``` in a browser. 

> please make the ```var/``` directory is writable by the server. 

Directory Structure
----

### app directory

The ```app``` directory is for keeping scripts and configurations to construct a web application. In the ```app``` directory, the ```app.php``` is the PHP script that constructs and serves the web application. 

For routing, look for ```app/routes.php``` file. 

How about adding the following code, somewhere after ```// add routes``` comments?

```php
$routes->get( '/new', function($request) {
    /** @var Request $request */
    return $request->respond()->asText('just added a new page!');
});
```

and access ```http://localhost:8888/new```, and you should see the text above. 