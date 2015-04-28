<?php /** @var \Tuum\Web\View\Value $view */ ?>

<?php $this->blockAsSection('controller/sub-menu', 'sub-menu', ['current' => 'message']); ?>

<?php $this->startSection() ?>
<li><a href="<?= $view->data->basePath; ?>?name=Controller Sample" >Controller Sample</a></li>
<li class="active">Message</li>
<?php $this->endSectionAs('breadcrumb'); ?>


<h1>Let's Jump!</h1>

<p>This is from SampleController::onJump().</p>
<p>and a sample/welcome view file.</p>

<form name="jump" method="get" action="jumper">
    <label for="message" >Enter Message:</label>
    <input type="text" name="message" id="message" value="message" />
    <input type="submit" value="jump" />
</form>

