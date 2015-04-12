<?php
$current = isset($current) ? $current : 'welcome';
$activate = function($case) use($current) {
    return $case === $current ? ' class="active"': '';
}
?>
<ul class="nav nav-pills nav-stacked">
    <li<?= $activate('welcome')?>><a href="/sample?name=tuum" >welcome</a></li>
    <li<?= $activate('hello')?>><a href="/sample/Tuum-Project" >hello</a></li>
    <li<?= $activate('message')?>><a href="/sample/jump" >redirect with message</a></li>
    <li<?= $activate('forms')?>><a href="/sample/forms" >form samples</a></li>
    <li<?= $activate('create')?>><a href="/sample/create" >create form</a></li>
</ul>