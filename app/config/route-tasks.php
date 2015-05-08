<?php

use Tuum\Web\Stack\RouterStack;
use Tuum\Web\Web;

/** @var Web $web */
/** @var RouterStack $stack */

/**
 * configure RouterStack for DemoTask.
 *
 * set root directory for the demo application using {*}
 * (so that the app does not have to know the root directory).
 */
$task_dir =  dirname(dirname(__DIR__)) . '/src/Tasks';
$stack = $web->configure(
    $task_dir . '/scripts/getRouterStack',
    [
        'view_dir' => $task_dir . '/views',
    ]
);

// set its root.
$stack->setRoot('/demoTasks{*}');

return $stack;