<?php

use Tuum\View\Renderer;
use Tuum\Web\Application;
use Tuum\Web\Stack\RouterStack;
use Tuum\Web\Web;

/** @var Web $web */
/** @var Application $app */
/** @var RouterStack $stack */
/** @var Renderer $views */

/**
 * configure RouterStack for DemoTask.
 *
 * set root directory for the demo application using {*}
 * (so that the app does not have to know the root directory).
 */
$stack  = $web->getRouterStack();

$task_dir   = dirname(dirname(__DIR__)) . '/src/Tasks';
$app->configure(
    $task_dir . '/scripts/getRouterStack', [
        'web'  => $web,
        'stack' => $stack,
        'view_dir' => null,
    ]
);
$stack->setRoot('/demoTasks{*}');

return $stack;