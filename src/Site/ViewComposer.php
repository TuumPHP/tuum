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

        // set main layout based on root uri.
        $root = explode('/', trim($request->getUri()->getPath(), '/'))[0];
        $this->setLayout($response, $root);

        // set sub-menu based on root uri.
        if ($root === 'docs') {
            $this->viewDocs($request, $response, $root);
        }
        elseif ($root === 'demoTasks') {
            $this->viewDemoTasks($request, $response, $root);
        }

        return $response;
    }

    /**
     * set up for directory served by demoTasks.
     *
     * @param Request  $request
     * @param Response $response
     * @param string   $root
     */
    private function viewDemoTasks($request, $response, $root)
    {
        // find breadcrumb title.
        $titleList   = [
            'index'   => 'Task List',
            'create'   => 'Create New Task',
            'init'     => 'Initialization',
        ];
        $file_name  = $this->buildFileName($request, $titleList);
        $breadcrumb = $this->buildBreadCrumb($titleList, $file_name);

        /** @var ViewStream $view */
        $view = $response->getBody();
        $data = ['file_name' => $file_name, 'base' => $root];
        $view->modRenderer(function($renderer) use($breadcrumb, $data) {
            /** @var Renderer $renderer */
            $renderer->section->set('breadcrumb', $breadcrumb);
            $renderer->blockAsSection('tasks/sub-menu', 'sub-menu', $data);
            return $renderer;
        });
    }

    /**
     * set up for directory served by DocView.
     *
     * @param Request  $request
     * @param Response $response
     * @param string   $root
     */
    private function viewDocs($request, $response, $root)
    {
        // find breadcrumb title.
        $titleList   = [
            'index'            => 'Documents Top',
            'quick-install'    => 'Installation',
            'quick-routing'    => 'Routes File',
            'quick-controller' => 'Controller and View',
            '' => '',
        ];
        $file_name  = $this->buildFileName($request, $titleList);
        $breadcrumb = $this->buildBreadCrumb($titleList, $file_name);

        /** @var ViewStream $view */
        $view = $response->getBody();
        $data = ['file_name' => $file_name, 'base' => $root];
        $view->modRenderer(function($renderer) use($breadcrumb, $data) {
            /** @var Renderer $renderer */
            $renderer->section->set('breadcrumb', $breadcrumb);
            $renderer->blockAsSection('layout/docs-subMenu', 'sub-menu', $data);
            return $renderer;
        });
    }

    /**
     * set up default layout file for templates.
     *
     * @param Response $response
     * @param string   $root
     */
    private function setLayout($response, $root)
    {
        /** @var ViewStream $view */
        $view = $response->getBody();
        $view->modRenderer(function ($renderer) use ($root) {
            /** @var Renderer $renderer */
            $renderer->setLayout('/layout/layout', ['navMenu' => $root]);
        });
    }

    /**
     * @param Request $request
     * @param string $titleList
     * @return string
     */
    private function buildFileName($request, $titleList)
    {
        $file_name = basename($request->getUri()->getPath());
        $file_name = isset($titleList[$file_name]) ? $file_name : 'index';
        return $file_name;
    }

    /**
     * @param $titleList
     * @param $file_name
     * @return string
     */
    private function buildBreadCrumb($titleList, $file_name)
    {
        $breadTitle = $titleList[$file_name];
        $breadcrumb = "<li><a href=\"/demoTasks/\" >Task Demo</a></li>\n" .
            "<li class=\"active\">{$breadTitle}</li>";
        return $breadcrumb;
    }
}