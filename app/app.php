<?php

/**
 * Create The Web Application, $app.
 */

use Demo\Site\ViewComposer;
use Tuum\Web\Psr7\Request;
use Tuum\Web\Psr7\Respond;
use Tuum\Web\Web;

date_default_timezone_set('Asia/Tokyo');

require_once(dirname(__DIR__) . '/vendor/autoload.php');

#
# pre-configuration.
#

$debug        = isset($debug) ? $debug: false;

# read compiled class files.
call_user_func(
    include __DIR__ . '/utils/boot-compiled.php', $debug
);

# xhprof profiling
$xhProf_limit = isset($xhProf_limit) ? $xhProf_limit: '1.0';
call_user_func(
    include __DIR__ . '/utils/boot-xhprof.php', $xhProf_limit
);

#
# build and configure $app.
#


$web = Web::forge(__DIR__, $debug);
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
            ->pushCsRfStack()
            ->push($web->get(ViewComposer::class))
            ->pushViewStack()
            ->loadContainer()
        ;
    })
    ->loadConfig()
    ->loadEnvironment($web->vars_dir . '/env')
    ->pushConfig($web->config_dir . '/routes')
    ->pushConfig($web->config_dir . '/route-tasks')
    ->pushConfig($web->config_dir . '/documents')
;

# add a closure for testing purpose only.
$web->prepend(
    function ($request, $next) {
        /** @var Request $request */
        return $next ? $next($request->withAttribute('closure', function () {
            ;
        })) : null;
    });

return $web->getApp();
