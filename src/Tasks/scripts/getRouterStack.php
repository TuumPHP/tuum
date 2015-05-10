<?php

use App\Controller\TaskController;
use Demo\Tasks\TaskDao;
use League\Container\Container;
use Tuum\Router\RouteCollector;
use Tuum\View\Renderer;
use Tuum\Web\Psr7\Response;
use Tuum\Web\View\ViewEngineInterface;
use Tuum\Web\Application;
use Tuum\Web\Stack\RouterStack;
use Tuum\Web\View\ViewStream;
use Tuum\Web\Web;

/** @var Web $web */
/** @var Application $app */
/** @var RouterStack $stack */
/** @var RouteCollector $routes */
/** @var Container $dic */

/**
 * set up TaskDao factory.
 */
$app->set( TaskDao::class, function() use($web) {
    return new TaskDao($web->vars_dir.'/data/tasks.csv');
});

/**
 * configure the route.
 *
 * make sure the main application will specify the root
 * using {*} so that task application does not have to
 * know its root directory.
 */
$stack  = $web->getRouterStack();

$routes = $stack->getRouting();
$routes->any('/*', TaskController::class);

/**
 * set up view directory if $view_dir is present.
 */
if (isset($view_dir) && $view_dir) {

    // set view directory.
    /** @noinspection PhpUnusedParameterInspection */
    $stack->setAfterRelease(

        function($request, $response) use($view_dir) {
            /** @var Response $response */
            $stream = $response->getBody();
            if ($stream instanceof ViewStream) {
                $stream->modRenderer(function($renderer) use($view_dir) {
                    /** @var Renderer $renderer */
                    $renderer->setRoot($view_dir);
                });
            }
            return $response;
        }
    );
}

return $stack;