<?php
/**
 * set up for local environment.
 */
use Tuum\Web\Web;

/** @var Web $web */

$logger = $web->getLog();
$logger->info('local configuration.');

