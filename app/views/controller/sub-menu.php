<?php
$current = isset($current) ? $current : 'welcome';
$activate = function($case) use($current) {
    return $case === $current ? ' class="active"': '';
}
?>
<ul class="nav nav-pills nav-stacked">
    <li<?= $activate('welcome')?>><a href="/controller/?name=tuum" >welcome</a></li>
    <li<?= $activate('hello')?>><a href="/controller/Tuum-Project" >hello</a></li>
    <li<?= $activate('message')?>><a href="/controller/jump" >redirect with message</a></li>
    <li<?= $activate('forms')?>><a href="/controller/forms" >form samples</a></li>
    <li<?= $activate('create')?>><a href="/controller/create" >create form</a></li>
</ul>