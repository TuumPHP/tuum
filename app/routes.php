<?php

use Demo\Site\SampleController;
use Tuum\Router\RouteCollector;
use Tuum\Web\Psr7\Request;
use Tuum\Web\Stack\RouterStack;
use Tuum\Web\Application;
use Tuum\Web\Web;

/** @var Application $app */

// --------------------
// create basic routers
// --------------------

/** @var RouterStack $routeStack */
/** @var RouteCollector $routes */

$routeStack = $app->get(Web::ROUTER_STACK);
$routes     = $routeStack->getRouting();

// ----------
// add routes
// ----------

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
        'before' => function($request, $next) {
            /** @var Request $request */
            /** @var callable $next */
            return $next? $next($request->withAttribute('current', 'controller')): null;
        },
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

/*
 * add sample controller
 */
$routes->any( '/sample{*}', SampleController::class)->before(
    function($request, $next) {
        /** @var Request $request */
        /** @var callable $next */
        return $next? $next($request->withAttribute('current', 'controller')): null;
    });

/* -------------------
 * create router stack 
 */

$routeStack->setRoot('/');
$routeStack->setRoot('/closure*');
$routeStack->setRoot('/sample*');

return $routeStack;