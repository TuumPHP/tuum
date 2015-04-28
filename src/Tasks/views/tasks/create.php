<?php
use Tuum\Web\View\Value;

/** @var Value $view */

$inputs   = $view->inputs;
$forms    = $view->forms;
$data     = $view->data;
$tasks    = $data->extractKey('tasks');

?>

<h1>Task Demo / new task</h1>

    <form name="add" method="post" action="">
        <?= $data->hiddenTag('_token'); ?>
        <dl>
            
            <dt><?= $forms->label('task', 'task'); ?></dt>
            <dd>
                <?= $forms->text('task')->placeholder('add a new task...')->width('40em')->id(); ?>
                <?= $view->errors->get('task'); ?>
            </dd>
            
            <dt><label for="done-by">done by</label></dt>
            <dd>
                <?= $forms->date('done_by', $data['done_by'])->id(); ?>
                <?= $view->errors->get('done_by'); ?>
            </dd>
            
            <dt></dt>
            <dd><input type="submit" value="add task" class="btn btn-primary"/></dd>

        </dl>
    </form>

<h3>adding a new task without CsRf Token</h3>

    <p>This form does not have CsRf token. should return forbidden error.</p>
    <form name="add" method="post" action="">
        <dl>

            <dt>task</dt>
            <dd>
                <input type="text" name="task" value="<?= $inputs->get('task', $data['task']);?>" placeholder="add a new task..." style="width: 40em;"/>
                <?= $view->errors->get('task'); ?>
            </dd>

            <dt>done by</dt>
            <dd>
                <label><input type="date" name="done_by" value="<?= $inputs->get('done_by', $data['done_by']); ?>" /></label>
                <?= $view->errors->get('done_by'); ?>
            </dd>

            <dt></dt>
            <dd><input type="submit" value="add task" class="btn btn-primary"/></dd>

        </dl>
    </form>


