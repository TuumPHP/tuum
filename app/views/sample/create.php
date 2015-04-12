<?php /** @var \Tuum\View\Renderer $this */ ?>
<?php /** @var \Tuum\Web\View\Value $view */ ?>

<?php $this->blockAsSection('sample/sub-menu', 'sub-menu', ['current' => 'create']); ?>

<?php $this->startSection() ?>
<li><a href="<?= $view->data->basePath; ?>?name=Controller Sample">Controller Sample</a></li>
<li class="active">Create</li>

<?php $this->endSectionAs('breadcrumb'); ?>

<?php
/** @var Tuum\Form\Forms $forms */
$forms = $this->service('forms');
$data  = $view->data;
$input = $view->inputs;
$errors= $view->errors;

?>
<h1>Create Form</h1>

<form method="post" action="">
    <?= $view->data->hiddenTag('_token'); ?>
    
    <?=
    $forms->formGroup(
        $forms->label('you name', 'name'),
        '<input type="text" name="name" id="name" value="'.$input->get('name', $data->raw('name')). '" placeholder="maybe your name" class="form-control"/>'
    );?>
    <?= $errors->get('name'); ?>

    <?=
    $forms->formGroup(
        $forms->label('gender', 'gender'),
        $forms->radioList('gender', ['m' => 'male', 'f' => 'female'], $input->get('gender'))
    );
    ?>
    <?= $errors->get('gender'); ?>

    <?=
    $forms->formGroup(
        $forms->label('memo', 'memo'),
        '<textarea name="memo" id="memo" class="form-control" >'.$input->get('memo'). '</textarea>'
    );
    ?>
    <?= $errors->get('memo'); ?>
    
    <?=
    $forms->formGroup(
        $forms->label('SNS (facebook)', 'sns-facebook'),
        '<input type="text" name="sns[facebook]" id="sns-facebook" value="'.$input->get('sns[facebook]'). '"  class="form-control" placeholder="whatever but must have @ in it" />'
    );
    ?>
    <?= $errors->get('sns[facebook]'); ?>

    <?=
    $forms->formGroup(
        $forms->label('SNS (twitter)', 'sns-twitter'),
        '<input type="text" name="sns[twitter]" id="sns-twitter" value="'.$input->get('sns[twitter]'). '"  class="form-control" placeholder="whatever but must have @ in it" />'
    );
    ?>
    <?= $errors->get('sns[twitter]'); ?>
    
    <input type="submit" value="try validate input!" class="btn btn-primary"/>

</form> 