<?php
use Demo\Tasks\TaskDao;
use Tuum\Web\View\Value;

/** @var Value $view */

$inputs   = $view->inputs;
$data     = $view->data;
$basePath = $data['basePath'];
$tasks    = $data->extractKey('tasks');

?>

<h1>Task Demo</h1>

<style>
    span.done {
        color: gray;
        font-weight: normal;
    }
    span.active {
        color: blue;
        font-weight: bold;
    }
    form {
        display: inline;
    }
</style>

<?php if(!isset($tasks)) : ?>
    
    <form name="init" action="/demoTasks/initialize" method="post" >
        <?= $data->hiddenTag('_token'); ?>
        tasks are not defined. maybe 
        <input type="submit" value="initialize" class="btn btn-info"/> ?
    </form>
<?php else: ?>
    
<!--
  -- lists of tasks
  -->    

<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>task</th>
        <th>done by</th>
        <th>toggle</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($tasks->getKeys() as $key) :

        $task = $tasks->extractKey($key);
        $class = ($task[1] === TaskDao::ACTIVE) ? 'active' : 'done';
    ?>
    <tr>
        <td><?= $task[0] ?></td>
        <td>
            <span class="<?= $class; ?>" ><?= $task->get(2) ?></span>
            <?php
            if($task[1]===TaskDao::DONE) {
                ?>
                <form name="delete" method="post" action="<?= $basePath,'/', $task[0], '/delete'; ?>" >
                    <?= $data->hiddenTag('_token') ?>
                    <input type='submit' value='del' />
                </form>
                <?php
            }
            ?>
        </td>
        <td>
            <?= ($by = new DateTime($task[3])) ? $by->format('Y/m/d') : '---'; ?>
        </td>
        <td>
            <form name="toggle" method="post" action="<?= $basePath.'/'.$task[0].'/toggle' ?>" >
                <?= $data->hiddenTag('_token'); ?>
                <input type="submit" value="toggle" />
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

