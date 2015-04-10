<?php /** @var \Tuum\View\Renderer $this */ ?>

<?php $this->markSectionNoRender('breadcrumb'); ?>

<?php $this->startSection(); ?>

<div class="jumbotron" style="margin-top:20px;">
    <h1>TuumPHP framework</h1>
    <p>TuumPHP is yet-another micro framework for PHP.</p>
    <p><a href="https://github.com/TuumPHP/" target="_blank">source code≫</a></p>
</div>

<?php $this->endSectionAs('jumbotron'); ?>

<div class="col-md-4">
    <h3>URL Mappers</h3>
    <ul>
        <li><a href="docs/index.php" >php file</a></li>
        <li><a href="docs/tuum.html" >html file</a></li>
        <li><a href="docs/tuum.txt" >text file</a></li>
        <li><a href="docs/tuum.md" >markdown file (not found)</a></li>
        <li><a href="docs/errors.php" >php exception thrown</a></li>
    </ul>
</div>

<div class="col-md-4">
    <h3>Routes (closure style)</h3>
    <ul>
        <li><a href="closure">from closure</a></li>
        <li><a href="closure/text">raw text from a closure</a></li>
        <li><a href="closure/array">array from a closure</a></li>
        <li><a href="closure/view">a view file from closure-view</a></li>
    </ul>
</div>

<div class="col-md-4">
    <h3><a href="sample/?name=TuumPHP" >Controller Sample</a></h3>
    <p>This samples use SampleController class to render various pages.</p>
</div>

<div class="col-md-4">
    <h3><a href="demoTasks" >Demo Task Application</a></h3>
    <p>a demo task application defined as another stack. </p>
</div>


