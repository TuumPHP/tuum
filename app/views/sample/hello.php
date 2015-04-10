<?php /** @var \Tuum\View\Renderer $this */ ?>

<?php $this->blockAsSection('sample/sub-menu', 'sub-menu', ['current' => 'hello']); ?>

<?php $this->startSection() ?>
<li><a href="<?= $view->data->basePath; ?>?name=Controller Sample" >Controller Sample</a></li>
<li class="active">Hello</li>
<?php $this->endSectionAs('breadcrumb'); ?>


<?php

$name = $view->data['name'];

?>

<h1>Hello <?= $name; ?></h1>
<p>This is from SampleController::onHello( $name ),</p>
<p>and a sample/hello view file.</p>

