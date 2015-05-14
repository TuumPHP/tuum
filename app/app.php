<?php

/**
 * Create The Web Application, $app.
 */

use App\View\ViewComposer;
use Tuum\Web\Application;
use Tuum\Web\Psr7\Respond;
use Tuum\Web\Web;

date_default_timezone_set('Asia/Tokyo');

#
# pre-configuration.
#

# load autoloader 
require_once(dirname(__DIR__) . '/vendor/autoload.php');

# read compiled class files.
call_user_func(include __DIR__ . '/utils/boot-compiled.php', $config);

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
    $web = Web::forge($config);
    $web
        ->cacheApp(function($web) {
            /** @var Web $web */
            $web
                ->catchError([
                    'errors/error', // default error view
                    Respond::ACCESS_DENIED  => 'errors/forbidden',
                    Respond::FILE_NOT_FOUND => 'errors/not-found',
                ])
                ->pushSessionStack()
                ->pushCsRfStack('post:/*')
                ->pushViewStack($web->get(ViewComposer::class))
                ->pushDocViewStack($web->app_dir.'/documents', ['enable_raw' => true])
                ->loadContainer()
            ;
        })
        ->loadConfig()
        ->loadEnvironment($web->vars_dir . '/env')
        ->pushConfig($web->config_dir . '/routes')
        ->pushConfig($web->config_dir . '/route-tasks')
    ;

    return $web->getApp();
};

