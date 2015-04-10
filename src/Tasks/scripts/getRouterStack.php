<?php

use Demo\Tasks\TaskController;
use Demo\Tasks\TaskDao;
use League\Container\Container;
use Tuum\Router\RouteCollector;
use Tuum\View\Tuum\Renderer;
use Tuum\Web\Application;
use Tuum\Web\Stack\RouterStack;
use Tuum\Web\Web;

/** @var Application $app */
/** @var RouterStack $routeStack */
/** @var RouteCollector $routes */
/** @var Container $dic */

/**
 * set up TaskDao factory.
 */
$app->set( TaskDao::class, function() use($dic) {
    return new TaskDao($dic->get(Web::VAR_DATA_DIR).'/data/tasks.csv');
});


/**
 * configure the route.
 *
 * make sure the main application will specify the root
 * using {*} so that task application does not have to
 * know its root directory.
 */
$routeStack = $app->get(Web::ROUTER_STACK);
$routes     = $routeStack->getRouting();

$routes->any('/*', TaskController::class);


/**
 * configure the views.
 *
 * use the view files as specified by the parent.
 * specify another directory if there are another
 * view directory prepared for the demo.
 */
/** @var Renderer $views */
$views = $app->get(Web::RENDER_ENGINE);

if (isset($view_dir) && $view_dir) {
    $views->locator->addRoot($view_dir);
} else {
    $views->locator->addRoot(dirname(__DIR__) . '/views');
}

return $routeStack;