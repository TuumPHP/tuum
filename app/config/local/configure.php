<?php
use League\Container\Container;
use Monolog\Logger;
use Tuum\Web\Web;

/** @var Container $dic */

/** @var Logger $logger */
$logger = $dic->get(Web::LOGGER);
$logger->info('local configuration.');

/**
 * set up for local environment.
 */