<?php

use Tuum\Web\Application;

/**
 * an experimental boot script to use cached/serialized $app. 
 *
 * @param array $config
 * @return Application
 */

return function( array $config ) use($boot) {

    /** @var Application $app */
    
    /*
     * build $boot.
     */
    $cache_file = $config['var'].'/app.cache.php';
    if(file_exists($cache_file)) {
        $app = unserialize(include($cache_file));
    } else {
        $app = $boot($config);
        file_put_contents($cache_file, "<?" . "php return '".serialize($app)."';");
    }
    
    // -----------------------------------------------
    // read the routes.
    // routes often have closures, so run routes here. 
    // 
    // the route files are out of the config directory. 
    // -----------------------------------------------

    $route_files = (array) $config['routes'];
    foreach($route_files as $routes ) {
        $app->push($app->configure($routes));
    }

    return $app;
};