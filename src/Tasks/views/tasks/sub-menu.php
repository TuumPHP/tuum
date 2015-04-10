<?php
$current = isset($current) ? $current : 'list';
$activate = function($case) use($current) {
    return $case === $current ? ' class="active"': '';
}
/** @var string $base */
?>
<ul class="nav nav-pills nav-stacked">
    <li<?= $activate('list')?>><a href="<?= $base; ?>/" >Task List</a></li>
    <li<?= $activate('new')?>><a href="<?= $base; ?>/create" >new task</a></li>
    <li><hr></li>
    <li<?= $activate('init')?>><a href="<?= $base; ?>/init" >initialize</a></li>
</ul>