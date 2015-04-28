<?php
$file_name = isset($file_name) ? $file_name : 'index';
$activate = function($case) use($file_name) {
    return $case === $file_name ? ' class="active"': '';
}
/** @var string $base */
?>
<ul class="nav nav-pills nav-stacked">
    <li<?= $activate('index')?>><a href="/<?= $base; ?>/" >Task List</a></li>
    <li<?= $activate('create')?>><a href="/<?= $base; ?>/create" >new task</a></li>
    <li><hr></li>
    <li<?= $activate('init')?>><a href="/<?= $base; ?>/init" >initialize</a></li>
</ul>