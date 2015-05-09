<?php

/**
 * Create The Web Application, $app.
 */

use Tuum\Web\Application;
use Tuum\Web\Web;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

# xhprof profiling
call_user_func(include __DIR__ . '/utils/boot-xhprof.php', $config);

#
# build and configure $app.
#

/**
 * a closure to build $app.
 *
 * @param array $config
 * @return Application
 */
return function(array $config)
{
    $web =Web::forge($config);
    $web->pushConfig($web->config_dir . '/route-fast');

    return $web->getApp();
};

