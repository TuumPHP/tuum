<?php

/**
 * Create The Web Application, $app.
 */

use Tuum\Web\Web;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

$xhProf_limit = isset($xhProf_limit) ? $xhProf_limit: '1.0';
include __DIR__ . '/utils/boot-xhprof.php';

#
# build and configure $app.
#

$app =Web::forge(__DIR__);
$app->pushConfig($app->config_dir . '/route-fast');

return $app;
