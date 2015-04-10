<?php

use Tuum\Web\Web;
use Tuum\Web\Application;

/**
 * function to pre-process before booting a web application.
 * $boot must exist.
 *
 * @param array $config
 * @return Application
 */

return function( array $config ) use($boot) {

    /*
     * read compiled php file,
     * if debug is false, and compiled.php exists.
     */
    $compiled = $config[Web::VAR_DATA_DIR].'/compiled.php';
    if(!$config[Web::DEBUG] && file_exists($compiled)) {
        include_once($compiled);
    }

    /*
     * build $boot.
     */
    return $boot($config);
};