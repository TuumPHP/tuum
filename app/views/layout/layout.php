<?php
use Tuum\View\Renderer;
use Tuum\Web\View\Value;

/** @var Value $view */
/** @var Renderer $this */

// main title in header. 
if (!isset($title)) {
    $title = 'Tuum Demo';
}

// set menu highlight
$navMenu = isset($navMenu) ? $navMenu: 'none';
$activate = function($case) use($navMenu) {
    return $case === $navMenu ? ' class="active"': '';
};

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title><?= $title; ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/common/tuum.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <!--suppress CssUnusedSymbol -->
    <style type="text/css"></style>
</head>
<body>

<nav id="header" class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Tuum</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li<?= $activate('docs');?>><a href="/docs/index">Documents</a></li>
                <li<?= $activate('closure');?>><a href="/closure/view">Closure Sample</a></li>
                <li<?= $activate('controller');?>><a href="/controller?name=Tuum+framework">Controller Sample</a></li>
                <li<?= $activate('demoTasks' );?>><a href="/demoTasks">Task Demo</a></li>
            </ul>
        </div>
    </div>
</nav>

<?php $this->section->start(); ?>

<ol class="breadcrumb">
    <li><a href="/" >Main Page</a></li>
    <?= $this->section->get('breadcrumb'); ?>
</ol>

<?php $this->section->renderAs('breadcrumb'); ?>

<div class="container" id="main">

    <?= $this->section->get('jumbotron'); ?>
    
    <?= $view->message; ?>
    
    <?php if($this->section->exists('sideBar', 'sub-menu')) : ?>
        
        <div class="col-md-3">
            <br/>
            <?= $this->section->get('sub-menu'); ?>
            <?= $this->section->get('sideBar'); ?>
        </div>
        <div class="col-md-9">
            <?= $this->getContent();?>
        </div>

    <?php else: ?>
        
        <div class="col-md-12">
            <?= $this->getContent();?>
        </div>
        
    <?php endif; ?>
    
</div>

<nav id="footer" class="nav navbar-fixed-bottom">
    <div class="container">
        <h4>Tuum framework.</h4>
        <p><em>Tuum</em> means 'yours' in Latin; so it happens to the same pronunciation as 'stack' in Japanese. </p>
    </div>
</nav>

</body>
</html>