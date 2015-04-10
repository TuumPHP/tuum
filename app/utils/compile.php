<?php

/**
 * script to create a compiled php classes using ClassPreLoader.
 */

use ClassPreloader\Command\PreCompileCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Tuum\Web\Web;

$vendor_dir = dirname(dirname(__DIR__)).'/vendor';
require_once( $vendor_dir.'/autoload.php');


/*
 * set up class preLoader script.
 */
$getIncludes = __DIR__.'/compile-includes.php';
$config      = include dirname(__DIR__).'/config.php';
$outputPath  = $config[Web::VAR_DATA_DIR].'/compiled.php';

/*
 * run compilation
 */
$command = new PreCompileCommand();
$command->run(
    new ArrayInput([
            '--config' => $getIncludes,
            '--output' => $outputPath,
            '--strip_comments' => 1,
        ]),
    new NullOutput
);