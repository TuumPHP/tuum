<?php
namespace Demo\Tasks;

use Tuum\Web\Controller\AbstractController;
use Tuum\Web\Controller\RouteDispatchTrait;
use Tuum\Web\Psr7\Response;

class TaskController extends AbstractController
{
    use RouteDispatchTrait;

    /**
     * @var TaskDao
     */
    protected $dao;

    /**
     * @param TaskDao $dao
     */
    public function __construct(TaskDao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @param string $dir
     * @return TaskController
     */
    public static function forge($dir)
    {
        return new self(
            new TaskDao($dir.'/tasks.csv')
        );
    }
    
    /**
     * @return array
     */
    protected function getRoutes()
    {
        return [
            'get:/'             => 'index',
            'get:/create'       => 'create',
            'post:/create'      => 'insert',
            'get:/init'         => 'init',
            'post:/init'        => 'initData',
            'post:/{id}'        => 'update',
            'post:/{id}/toggle' => 'toggle',
            'post:/{id}/delete' => 'delete',
        ];
    }

    /**
     * @return Response
     */
    public function onIndex()
    {
        $tasks = $this->dao->getTasks();
        return $this->respond()
            ->with('tasks', $tasks)
            ->with('done_by', (new \DateTime('now'))->format('Y-m-d'))
            ->asView('tasks/index');
    }

    /**
     * create 5 initial tasks.
     *
     * @return Response
     */
    public function onInit()
    {
        return $this->respond()
            ->asView('tasks/init');
    }

    /**
     * create 5 initial tasks.
     *
     * @return Response
     */
    public function onInitData()
    {
        $this->dao->initialize();
        return $this->redirect()
            ->withMessage('initialized tasks.')
            ->toBasePath();
    }

    /**
     * toggle status between ACTIVE <-> DONE.
     *
     * @param $id
     * @return Response
     */
    public function onToggle($id)
    {
        if($this->dao->toggle($id)) {
            return $this->redirect()
                ->toBasePath();
        }
        return $this->redirect()
            ->withError('cannot find task #'.$id)
            ->toBasePath();
    }

    /**
     * deletes task $id.
     *
     * @param $id
     * @return Response
     */
    public function onDelete($id)
    {
        if($this->dao->delete($id)) {
            return $this->redirect()
            ->withMessage('deleted task #'.$id)
                ->toBasePath();
        }
        return $this->redirect()
            ->withError('cannot find task #'.$id)
            ->toBasePath();
    }

    /**
     * form for creating a new task
     * 
     * @return Response
     */
    public function onCreate()
    {
        return $this->respond()
            ->with('done_by', (new \DateTime('now'))->format('Y-m-d'))
            ->asView('tasks/create');
    }

    /**
     * insert a new task.
     *
     * @return Response
     */
    public function onInsert()
    {
        $input = $this->request->getParsedBody();
        $errors = $this->validate($input);
        if(!empty($errors)) {
            return $this->redirect()
                ->withError('please check the new task to enter!')
                ->withInput($input)
                ->withInputErrors($errors)
                ->toBasePath('create');
        }
        if(!$id = $this->dao->insert($input['task'], $input['done_by'])) {
            return $this->redirect()
                ->withError('cannot add a new task, yet!')
                ->toBasePath('create');
        }
        return $this->redirect()
            ->withMessage('added a new task #'.$id)
            ->toBasePath();
    }

    /**
     * @param array $input
     * @return array
     */
    private function validate($input)
    {
        $errors = [];
        if(!isset($input['task']) || !$input['task']) {
            $errors['task'] = 'please write a task to accomplish!';
        }
        if(!isset($input['done_by']) || !$input['done_by']) {
            $errors['done_by'] = 'please enter a date!';
        }
        return $errors;
    }
}
