<?php

/** @var Web $web */

use Tuum\Web\Web;

$stack = $web->getDocViewStack($web->app_dir . '/documents');

$stack->enable_raw = true;
$stack->setRoot('docs*');

return $stack;