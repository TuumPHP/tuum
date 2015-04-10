<?php

use Tuum\View\Tuum\Renderer;
use Tuum\Web\Application;
use Tuum\Web\Psr7\Request;
use Tuum\Web\Stack\RouterStack;

/** @var Application $app */
/** @var RouterStack $routeStack */
/** @var Renderer $views */

/**
 * configure RouterStack for DemoTask.
 *
 * set root directory for the demo application using {*}
 * (so that the app does not have to know the root directory).
 */
$task_dir   = dirname(__DIR__) . '/src/Tasks';
$routeStack = $app->configure(
    $task_dir . '/scripts/getRouterStack'
);
$routeStack->setRoot('/demoTasks{*}');
$routeStack->setBeforeFilter(
    function($request, $next) {
    /** @var Request $request */
    /** @var callable $next */
    return $next? $next($request->withAttribute('current', 'demoTasks')): null;
});

return $routeStack;