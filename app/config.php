<?php

/**
 * returns configuration array.
 *
 * @return array
 */

use Tuum\Web\Web;

return [

    /*
     * config directory.
     */
    Web::CONFIG_DIR => __DIR__.'/config',

    /*
     * view/template directory.
     */
    Web::TEMPLATE_DIR  => __DIR__.'/views',

    /*
     * document/resource directory.
     */
    Web::DOCUMENT_DIR   => __DIR__.'/documents',

    /*
     * variables (cache, logs, etc.) directory.
     */
    Web::VAR_DATA_DIR    => dirname(__DIR__).'/var',

    /*
     * debug is on (true) or off (false).
     */
    Web::DEBUG  => true,

    /*
     * routes files
     */
    'routes' => [
        __DIR__.'/routes',
        __DIR__.'/route-tasks',
    ],
    
    /*
     * environment file. should return an array of environments.
     */
    'env_file' => dirname(__DIR__).'/var/env.php',
    
    /*
     * xh-profiler limit time
     */
    'xhprof-limit' => '1.0',
];
