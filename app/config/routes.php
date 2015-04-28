<?php
/**
 * routes.php
 * 
 * configures routes for the web application. 
 * 
 * receives $stack as RouterStack to start. 
 * must return the $stack to push to the stack.
 * 
 */
use Demo\Site\SampleController;
use Tuum\Router\RouteCollector;
use Tuum\Web\Psr7\Request;
use Tuum\Web\Stack\RouterStack;
use Tuum\Web\Application;
use Tuum\Web\Web;

/** @var Web $web */
/** @var Application $app */
/** @var RouterStack $stack */
/** @var RouteCollector $routes */

/**
 * start routing using RouteCollection object, $routes. 
 */

$stack  = $web->getRouterStack();
$routes = $stack->getRouting();

// main root

$routes->get( '/', function($request) {
    /** @var Request $request */
    return $request->respond()->asView('index');
});


/**
 * routes for closure/ pattern.
 * all are from closure.
 */
$routes->group(
    [
        'pattern' => '/closure',
    ],
    function($routes) {
        /** @var RouteCollector $routes */

        $routes->get( '', function($request) {
            /** @var Request $request */
            return $request->respond()->asHtml('<html><body><h1>This is from a closure!</h1></body></html>');
        });

        $routes->get( '/view', function($request) {
            /** @var Request $request */
            return $request->respond()->asView('closure-view');
        });

        $routes->get( '/text', function() {
            return 'a text from closure';
        });

        $routes->get( '/array', function() {
            return ['arrays' => 'json'];
        });

    });

/**
 * add sample controller route
 */

$routes->any( '/sample{*}', SampleController::class);


/** ---------------------------------------------------
 * finished routing. 
 * 
 * must return the router stack from routes file. 
 * or return null not to push to the middleware stack. 
 */

return $stack;