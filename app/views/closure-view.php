<?php /** @var \Tuum\View\Renderer $this */ ?>
<?php /** @var \Tuum\Web\View\Value $view */ ?>

<?php $view->data['current'] = 'closure'; ?>

<?php $this->section->start() ?>
<li><a href="/closure/view" >Closure Sample</a></li>
<li class="active">view file</li>
<?php $this->section->saveAs('breadcrumb'); ?>

<html>
<body>
<h1>Sample URLs</h1>
<p>Lists some sample URLs. This page is rendered by a closure.</p>

<h3>Closure Samples</h3>
<ul>
    <li><a target="_blank" href="/closure">Html closure (text/html)≫</a></li>
    <li><a target="_blank" href="/closure/text">raw text (text/plain)≫</a></li>
    <li><a target="_blank" href="/closure/array">array (text/JSON)≫</a></li>
</ul>

<h3>DocView Samples</h3>
<ul>
    <li><a target="_blank" href="/samples/tuum.html" >html file≫</a></li>
    <li><a target="_blank" href="/samples/tuum" >text file≫</a> (<a target="_blank" href="/samples/tuum.txt" >raw text file≫</a>)</li>
    <li><a target="_blank" href="/samples/marked" >markdown file≫</a> (<a target="_blank" href="/samples/marked.md" >raw markdown file≫</a>)</li>
    <li><a target="_blank" href="/samples/errors" >php exception thrown≫</a></li>
</ul>

</body>
</html>