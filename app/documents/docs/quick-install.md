Installation
============

A quick step to install Tuum framework. 

Quick Step
---

Use starter repository on gitHub and composer to install Tuum framework.

```sh
git clone https://github.com/TuumPHP/tuum
cd tuum
composer install
```

> please make the ```var/``` directory writable to the server.

To use PHP's internal server,

```
cd public
php -S localhost:8888 index.php
```

and access http://localhost:8888 in a browser.

Directories
-----

Installation process will produce 4 directories as;

*   app/ : configuration and application scripts.
*   public/ : web public directory.
*   src/ : classes for your application.
*   var/ : to store data, log, caches, etc. that are not version controlled. 
*   vendor/ : composer's installation directory. 

