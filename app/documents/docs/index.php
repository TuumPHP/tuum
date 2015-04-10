<?php /** @var \Tuum\View\Renderer $this */ ?>
<?php /** @var \Tuum\Web\View\Value $view */ ?>

<?php $view->data['current'] = 'maps'; ?>

<?php $this->startSection() ?>
<li><a href="/docs/index.php" >URL Map Sample</a></li>
<li class="active">PHP File</li>
<?php $this->endSectionAs('breadcrumb'); ?>

<!Doctype html>
<html>
<head>
    <title>TuumPHP is here</title>
</head>
<body>
<h1>PHP View File</h1>
<p>This is directly rendered from a PHP file.</p>

<h3>URL Map Samples</h3>
<ul>
    <li><a href="docs/tuum.html" >html file</a></li>
    <li><a href="docs/tuum.txt" >text file</a></li>
    <li><a href="docs/tuum.md" >markdown file (not found)</a></li>
    <li><a href="docs/errors.php" >php exception thrown</a></li>
</ul>

</body>
</html>