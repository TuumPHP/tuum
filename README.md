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

### simple routing using closure

The directory, ```app/```, contains scripts and configurations to construct a web application. The ```app/routes.php``` file contains routes definitions. 

So, how about adding the following code, somewhere after ```// add routes``` comments?

```php
$routes->get( '/new', function($request) {
    /** @var Request $request */
    return $request->respond()->asText('just added a new page!');
});
$routes->get( '/json', function($request) {
    /** @var Request $request */
    return $request->respond()->asJson(['Hello' => 'World']);
});
```

and access ```http://localhost:8888/new``` or ```http://localhost:8888/json```, and you should see the text and json data above. 


### view and controller

The controller and view template samples are at URL below:

 ```http://localhost:8800/sample?name=TuumPHP```. 

The routes file, ```app/routes.php```, converts the above URL request to a controller object by the following code;

```php
$routes
    ->any( '/sample{*}', SampleController::class)
    ->before(function($request, $next) {
        /** @var Request $request */
        /** @var callable $next */
        return $next? $next($request->withAttribute('current', 'controller')): null;
});
```

The ```SampleController``` class is in the ```src/``` directory which contains all the PHP classes. A closure type filter is set for the URL, by setting an attribute to the $request. 


The ```app/views``` contains templates used in this demo site, while 


Directory Structure
----

The ```app``` directory is for keeping scripts and configurations to construct a web application. In the ```app``` directory, the ```app.php``` is the PHP script that constructs and serves the web application. 

