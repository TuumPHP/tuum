<?php
use Tuum\Web\Psr7\Request;
use Tuum\Web\Psr7\RequestFactory;
use Tuum\Web\Application;

require_once( dirname( __DIR__ ) . '/vendor/autoload.php' );

/** @var \Closure $boot */
/** @var Application $app */

date_default_timezone_set('Asia/Tokyo');

/*
 * get configuration
 */
$config = include __DIR__.'/config.php';

// xhprof profiling
include __DIR__.'/utils/xhprof.php';

/*
 * boot $app
 */
$boot = include __DIR__ . '/utils/boot.php';
$boot = include __DIR__ . '/utils/boot-compiled.php';
$boot = include __DIR__ . '/utils/boot-config.php';
/** @var Application $app */
$app  = $boot($config);
$app->prepend(
    function($request, $next) {
    /** @var Request $request */
    return $next?$next($request->withAttribute('closure', function(){;})) : null;
});
/*
 * run $app
 */
$request  = RequestFactory::fromGlobals();
$response = $app->__invoke( $request );
$response->send();
