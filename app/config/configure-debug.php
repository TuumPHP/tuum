<?php

use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Logger;
use Tuum\Web\Web;

/** @var Web $web */

/**
 * set up logger for browser's console
 */

/** @var Logger $logger */
$logger = $web->getLog();

if($logger) {
    $logger->pushHandler(
        new BrowserConsoleHandler(Logger::DEBUG)
    );
    $logger->info('debug mode.');
}

