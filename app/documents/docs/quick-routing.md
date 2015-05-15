Routing
=======

A quick overview of routing in Tuum framework. 

Routes File
----

The route file, ```app/config/routes.php``` is located in ```app/``` directory, 
which also contains other scripts and configurations to construct a web application. 


### app/app.php file

The ```app/app.php``` file constructs the web application. 

```php
return function(array $config)
{
    $web = Web::forge($config);
    $web
        /* ...snip... */
        ->loadConfig()
        ->loadEnvironment($web->vars_dir . '/env')
        ->pushConfig($web->config_dir . '/routes')   // <- routing
        ->pushConfig($web->config_dir . '/route-tasks')
    ;

    return $web->getApp();
};
```

The routing is done at the line,

```php
    ->pushConfig($web->config_dir . '/routes')   // <- routing
```

which reads the routes in ```app/config/routes.php``` file. 


### app/config/routes.php file

Let's take a look at the route file, ```app/config/routes.php``` file. 

At the beginning of the route file, the script obtains two objects from the application: 

*   RouterStack (```$stack```), a middleware for routing and dispatching a route, and 
*   RouteCollector (```$routes```), collects routes for the application.

At the end of the route file, the script must return the configured ```$stack``` 
to be pushed to the middleware stack of the application. 

The overall route file should like like, as follows. 

```php
$stack  = $web->getRouterStack();
$routes = $stack->getRouting();

/**
 * collects routes below. 
 */
$routes->get('/*', ... );

/** ---------------------------------------------------
 * finished routing. 
 */
return $stack;
```


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


Request and Response
--------------------

The examples above shows how to create a response from request. 

The request object has response factories, ```respond()``` for creating a view response, and ```redirect()``` for redirect response. 
