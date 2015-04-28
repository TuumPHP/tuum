<?php
namespace Demo\Site;

use Tuum\View\Renderer;
use Tuum\Web\Psr7\Request;
use Tuum\Web\Psr7\Response;
use Tuum\Web\ReleaseInterface;
use Tuum\Web\View\ViewStream;

class ViewComposer implements ReleaseInterface
{
    /**
     * @param Request       $request
     * @param callable|null $next
     * @return null|Response
     */
    public function __invoke($request, $next = null)
    {
    }

    /**
     * @param Request       $request
     * @param null|Response $response
     * @return null|Response
     */
    public function release($request, $response)
    {
        if (is_null($response)) {
            $response = $request->respond()->asNotFound();
        }
        if (!$response->getBody() instanceof ViewStream) {
            return $response;
        }

        $this->setLayout($request, $response);
        
        $root = explode('/', trim($request->getUri()->getPath(), '/'))[0];
        if ($root === 'docs') {
            $this->viewDocs($request, $response);
        }
        elseif ($root === 'demoTasks') {
            $this->viewDemoTasks($request, $response, $root);
        }

        return $response;
    }

    /**
     * set up for docs directory served by DocView.
     *
     * @param Request  $request
     * @param Response $response
     */
    private function viewDemoTasks($request, $response, $root)
    {
        // start with file name. 
        $file_name = basename($request->getUri()->getPath());
        // find breadcrumb title. 
        $titleList   = [
            'index'   => 'Task List',
            'create'   => 'Create New Task',
            'init'     => 'Initialization',
        ];
        $file_name = isset($titleList[$file_name]) ? $file_name: 'index';
        $breadTitle = $titleList[$file_name];
        $breadcrumb = "<li><a href=\"/demoTasks/\" >Task Demo</a></li>\n".
            "<li class=\"active\">{$breadTitle}</li>";

        /** @var ViewStream $view */
        $view = $response->getBody();
        $view->modRenderer(function($renderer) use($breadcrumb, $file_name, $root) {
            /** @var Renderer $renderer */
            $renderer->setSection('breadcrumb', $breadcrumb);
            $renderer->blockAsSection('tasks/sub-menu', 'sub-menu', ['file_name' => $file_name, 'base' => $root]);
            return $renderer;
        });
    }

    /**
     * set up for docs directory served by DocView.
     * 
     * @param Request  $request
     * @param Response $response
     */
    private function viewDocs($request, $response)
    {
        // start with file name. 
        $file_name = basename($request->getUri()->getPath());

        // find breadcrumb title. 
        $titleList   = [
            'index'            => 'Documents Top',
            'quick-install'    => 'Installation',
            'quick-routing'    => 'Routes File',
            'quick-controller' => 'Controller and View',
            '' => '',
        ];
        $file_name = isset($titleList[$file_name]) ? $file_name: 'index';
        $breadTitle = $titleList[$file_name];
        $breadcrumb = "<li><a href=\"/docs/index\" >Documents</a></li>\n".
            "<li class=\"active\">{$breadTitle}</li>";
        
        /** @var ViewStream $view */
        $view = $response->getBody();
        $view->modRenderer(function($renderer) use($breadcrumb, $file_name) {
            /** @var Renderer $renderer */
            $renderer->setSection('breadcrumb', $breadcrumb);
            $renderer->blockAsSection('layout/docs-layout', 'sub-menu', ['file_name' => $file_name]);
            return $renderer;
        });
    }

    /**
     * set up default layout file for templates.
     * 
     * @param Request  $request
     * @param Response $response
     */
    private function setLayout($request, $response)
    {
        $path = $request->getUri()->getPath();
        $root = explode('/', trim($path, '/'))[0];
        /** @var ViewStream $view */
        $view = $response->getBody();
        $view->modRenderer(function ($renderer) use ($root) {
            /** @var Renderer $renderer */
            $renderer->setLayout('/layout/layout', ['navMenu' => $root]);
        });
    }
}