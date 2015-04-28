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
$current = isset($navMenu) ? $navMenu: 'none';
$activate = function($case) use($current) {
    return $case === $current ? ' class="active"': '';
};

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title><?= $title; ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <style type="text/css">
        nav#footer {
            background-color: #f0f0f0;
            border-top: 1px solid #cccccc;
        }
        nav#header {
            margin-bottom: 0;
        }
        ol.breadcrumb {
            border-radius: 0;
            background-color: #e7e7e7;
        }
        div#main {
            margin-bottom: 8em;
        }
        p.nav-header {
            margin: 1em 0 1em 0;
            font-weight: bold;
        }
    </style>
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
                <li<?= $activate('sample');?>><a href="/sample?name=Tuum+framework">Controller Sample</a></li>
                <li<?= $activate('demoTasks' );?>><a href="/demoTasks">Task Demo</a></li>
            </ul>
        </div>
    </div>
</nav>

<?php $this->startSection(); ?>

<ol class="breadcrumb">
    <li><a href="/" >Main Page</a></li>
    <?= $this->getSection('breadcrumb'); ?>
</ol>

<?php $this->renderAsSection('breadcrumb'); ?>

<div class="container" id="main">

    <?= $this->getSection('jumbotron'); ?>
    
    <?= isset($view) ? $view->message : ''; ?>
    
    <?php if($this->sectionExists('sideBar', 'sub-menu')) : ?>
        
        <div class="col-md-3">
            <br/>
            <?= $this->getSection('sub-menu'); ?>
            <?= $this->getSection('sideBar'); ?>
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