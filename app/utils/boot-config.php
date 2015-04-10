<?php

use Tuum\Web\Web;
use Tuum\Web\Application;

/**
 * set up a default configuration. 
 *
 * @param array $config
 * @return Application
 */
return function( array $config ) use($boot) {

    /**
     * default configuration.
     */

    $app_root       = dirname(__DIR__);
    $project_root   = dirname($app_root);
    $default_config = [
        'routes'          => $app_root . '/routes.php',
        'environment'     => [],
        Web::CONFIG_DIR   => $app_root . '/config',
        Web::TEMPLATE_DIR => $app_root . '/views',
        Web::DOCUMENT_DIR => $app_root . '/docs',
        Web::VAR_DATA_DIR => $project_root . '/var',
        Web::DEBUG        => false,
    ];
    $config += $default_config;

    // set up environment. read it from env_file.
    
    if(isset($config['env_file']) && file_exists($config['env_file'])) {
        $config['environment'] = (array) include($config['env_file']);
    }
    
    /*
     * build $boot.
     */
    return $boot($config);
};