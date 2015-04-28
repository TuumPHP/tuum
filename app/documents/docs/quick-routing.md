Routing
=======

A quick overview of routing in Tuum framework. 

Routes File
----

The directory, ```app/```, contains scripts and configurations to construct a web application. 

The routes are defined in ```app/config/routes.php``` file contains routes definitions. 

### RouterStack and RouteCollector

At the beginning of the ```routes.php``` file, the script obtains two objects 
from the application: RouterStack (```$stack```) and RouteCollector (```$routes```).

```php
$stack  = $web->getRouterStack();
$routes = $stack->getRouting();
```

The ```$stack``` is the middleware for routing and dispatching a handler.

The ```$routes``` collects routes for the application. 

> The ```$stack``` must be returned at the end of the script.

Routing Examples
----

### simple route

So, how about adding the following code, somewhere after ```$routes``` is obtained?

```php
$routes->get( '/new', function($request) {
    /** @var Request $request */
    return $request->respond()
    	->asContents('<h1>just added a new page!</h1>');
});
```

and access ```http://localhost:8888/new```, you should see the new page.

### redirect with message

Next example is to redirect back to the above page, with a message. 

```php
$routes->get( '/back', function($request) {
    /** @var Request $request */
    return $request->redirect()
    	->withMessage('just redirected back')
        ->toReferrer();
});
```

and access ```http://localhost:8888/back``` which redirect back to the ```/new``` page with a message, 'just redirected back'. 

