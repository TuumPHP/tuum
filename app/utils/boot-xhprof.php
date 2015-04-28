<?php

/**
 * enable xh-profiler
 */
return function ($xhProf_limit) {

    if (!function_exists('xhprof_enable')) {
        return;
    }
    xhprof_enable();
    $start_time = microtime(true);
    $app_name   = 'Tuum';
    $prof_root  = '/usr/local/Cellar/php56-xhprof/254eb24';

    /*
     * register xh-prof at shutdown.
     */
    register_shutdown_function(function () use ($app_name, $prof_root, $start_time, $xhProf_limit) {

        $xhprof_data = xhprof_disable();
        $end_time    = microtime(true);
        if ($end_time - $start_time < $xhProf_limit) {
            return;
        }

        include_once $prof_root . '/xhprof_lib/utils/xhprof_lib.php';
        include_once $prof_root . '/xhprof_lib/utils/xhprof_runs.php';

        /** @noinspection PhpUndefinedClassInspection */
        $xhprof_runs = new XHProfRuns_Default();
        /** @noinspection PhpUndefinedMethodInspection */
        $xhprof_runs->save_run($xhprof_data, $app_name);

    });

};
