<?php

/**
 * script to create a compiled php classes using ClassPreLoader.
 */

use ClassPreloader\Command\PreCompileCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

$vendor_dir = dirname(dirname(__DIR__)).'/vendor';
require_once( $vendor_dir.'/autoload.php');

#
# set up class preLoader script.
#
$config = call_user_func(include(dirname(__DIR__).'/config.php'), ['debug' => false, 'xhProf' => false]);

$getIncludes = __DIR__.'/compile-includes.php';
$outputPath  = $config['vars_dir'].'/compiled.php';

if (file_exists($outputPath)) {
    unlink($outputPath);
}
if (file_exists($config['vars_dir'].'/app.cache')) {
    unlink($config['vars_dir'].'/app.cache');
}

#
# run compilation
#

$command = new PreCompileCommand();
$command->run(
    new ArrayInput([
        '--config' => $getIncludes,
        '--output' => $outputPath,
        '--strip_comments' => 1,
    ]),
    new NullOutput
);