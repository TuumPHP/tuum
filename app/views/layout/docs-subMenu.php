<?php
/**
 * This is sub-menu for docs/ view files. 
 */

/** @var \Tuum\View\Renderer $this */
/** @var \Tuum\Web\View\Value $view */

$file_name   = isset($file_name) ? $file_name: 'index';
$activate    = function($case) use($file_name) {
    return $case === $file_name ? ' class="active"': '';
};

/**
 * set up the master layout. 
 */
?>

<ul class="nav nav-pills nav-stacked">
    <li role="presentation" <?= $activate('index')?>><a href="/docs/index" >Document Top</a></li>
</ul>

<p class="nav-header">Quick Start</p>
<ul class="nav nav-pills nav-stacked">
    <li<?= $activate('quick-install')?>><a href="/docs/quick-install" >Installation</a></li>
    <li<?= $activate('quick-routing')?>><a href="/docs/quick-routing" >Routes File</a></li>
    <li<?= $activate('quick-controller')?>><a href="/docs/quick-controller" >Controller and View</a></li>
</ul>

<p class="nav-header">Manual</p>
<ul class="nav nav-pills nav-stacked">
    <li<?= $activate('manual-http')?>><a href="#" >Request and Response</a></li>
    <li<?= $activate('manual-middleware')?>><a href="#" >Middleware</a></li>
    <li<?= $activate('manual-view')?>><a href="#" >View</a></li>
    <li<?= $activate('manual-forms')?>><a href="#" >Form Helper</a></li>
    <li<?= $activate('manual-router')?>><a href="#" >Router</a></li>
    <li<?= $activate('manual-controller')?>><a href="#" >Controller</a></li>
    <li<?= $activate('manual-performance')?>><a href="#" >Performance</a></li>
</ul>

