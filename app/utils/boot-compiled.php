<?php

/**
 * function to pre-process before booting a web application.
 * $boot must exist.
 *
 */

return function($debug, $var_dir=null) {

    if(!isset($debug) || $debug) {
        return;
    }

    if(!isset($var_dir)) {
        $var_dir = dirname(dirname(__DIR__)).'/var';
    }
    $compiled = $var_dir.'/compiled.php';
    if(file_exists($compiled)) {
        include_once($compiled);
    }
};

