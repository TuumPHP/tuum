<?php
namespace Demo\Site;

use Tuum\Web\Controller\AbstractController;
use Tuum\Web\Controller\RouteDispatchTrait;
use Tuum\Web\Psr7\Response;

class SampleController extends AbstractController
{
    use RouteDispatchTrait;

    /**
     * @return SampleController
     */
    public static function forge()
    {
        return new self;
    }

    /**
     * @return array
     */
    protected function getRoutes()
    {
        return [
            '/'        => 'welcome',
            '/jump'   => 'jump',
            '/jumper' => 'jumper',
            '/forms'  => 'forms',
            '/{name}' => 'hello',
        ];
    }

    /**
     * @param string $name
     * @return Response
     */
    protected function onHello($name)
    {
        return $this->respond()
            ->with('name', $name )
            ->asView('sample/hello')
            ;
    }

    /**
     * @return Response
     */
    protected function onWelcome($name='Tuum')
    {
        return $this->respond()
            ->with( 'name', $name )
            ->asView('sample/welcome')
            ;
    }

    /**
     * @return Response
     */
    protected function onJump()
    {
        return $this->respond()
            ->asView('sample/jump')
            ;
    }

    /**
     * @param string $message
     * @return Response
     */
    protected function onJumper($message='jumped')
    {
        return $this->redirect()
            ->withMessage($message)
            ->toBasePath('jump')
            ;
    }

    /**
     * @return Response
     */
    protected function onForms()
    {
        return $this->respond()
            ->asView('sample/forms');
    }
}
