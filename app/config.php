<?php

/**
 * set up default config array.
 * 
 * @param array $config
 * @return array
 */
return function(array $config = []) 
{
    $get = function($key, $default) use($config) {
        return isset($config[$key]) ? $config[$key] : $default;
    };
    $app_name   = $get('app_name', 'app');
    $app_dir    = $get('app_dir', __DIR__);
    $debug      = $get('debug', true);
    $xhProf     = $get('xhProf', false);
    $config_dir = $get('config_dir', $app_dir . '/config');
    $view_dir   = $get('view_dir', $app_dir . '/views');
    $vars_dir   = $get('vars_dir', dirname($app_dir) . '/var');

    return compact('app_name', 'app_dir', 'debug', 'xhProf', 'config_dir', 'view_dir', 'vars_dir');
};