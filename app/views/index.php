<?php /** @var \Tuum\View\Renderer $this */ ?>

<?php $this->section->markNotToRender('breadcrumb'); ?>

<?php $this->section->start(); ?>

<!-- Section: Jumbotron -->

<div class="jumbotron" style="margin-top:20px;">
    <h1>Tuum framework</h1>
    <p>Tuum is yet-another PHP framework for building a web site.</p>
    <p><a href="https://github.com/TuumPHP/" target="_blank">source code≫</a></p>
</div>

<?php $this->section->saveAs('jumbotron'); ?>

<!-- Content: index -->

<div class="col-md-4">
    <h3><a href="docs/index" >Documents</a></h3>
    <p>Documents on how to install and use the Tuum framework, as well as the background of the design.</p>
    <ul>
        <li><a href="docs/index" >Document Top</a></li>
        <li><a href="#" >Quick Start</a></li>
        <li><a href="#" >Technical Design</a></li>
    </ul>
</div>

<div class="col-md-4">
    <h3><a href="closure/view">Sample Urls</a></h3>
    <p>Samples of pages generated by closures and DocView.</p>
    <h4>Error Samples</h4>
    <ul>
        <li><a href="non-such.html">not found</a></li>
        <li><a href="samples/errors" >php exception thrown</a></li>
        <li><form action="test" method="post" ><input type="submit" value="forbidden error" /></form></li>
    </ul>
</div>

<div class="col-md-4">
    <h3>Sample Controller and Application</h3>
    <h4><a href="sample/?name=Tuum+framework" >Controller Sample</a></h4>
    <p>This samples use SampleController class to render various pages.</p>
    <h4><a href="demoTasks" >Demo Task Application</a></h4>
    <p>a demo task application defined as another stack. </p>
</div>


