<?php /** @var \Tuum\Web\View\Value $view */ ?>

<?php $this->blockAsSection('controller/sub-menu', 'sub-menu', ['current' => 'hello']); ?>

<?php $this->section->start() ?>
<li><a href="<?= $view->data->basePath; ?>?name=Controller Sample" >Controller Sample</a></li>
<li class="active">Hello</li>
<?php $this->section->saveAs('breadcrumb'); ?>


<?php

$name = $view->data['name'];

?>

<h1>Hello <?= $name; ?></h1>
<p>This is from SampleController::onHello( $name ),</p>
<p>and a sample/hello view file.</p>

