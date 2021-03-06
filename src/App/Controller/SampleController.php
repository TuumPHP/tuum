<?php
namespace App\Controller;

use Tuum\Web\Controller\AbstractController;
use Tuum\Web\Controller\RouteDispatchTrait;
use Tuum\Web\Psr7\Response;

class SampleController extends AbstractController
{
    use RouteDispatchTrait;

    /**
     * @var SampleValidator
     */
    private $validator;

    /**
     * @param SampleValidator $validator
     */
    public function __construct(SampleValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return array
     */
    protected function getRoutes()
    {
        return [
            '/'       => 'welcome',
            '/jump'   => 'jump',
            '/jumper' => 'jumper',
            '/forms'  => 'forms',
            'get:/create'  => 'create',
            'post:/create' => 'insert',
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
            ->asView('controller/hello')
            ;
    }

    /**
     * @return Response
     */
    protected function onWelcome($name='Tuum')
    {
        return $this->respond()
            ->with( 'name', $name )
            ->asView('controller/welcome')
            ;
    }

    /**
     * @return Response
     */
    protected function onJump()
    {
        return $this->respond()
            ->with('flashed', $this->request->getAttribute('flashed'))
            ->asView('controller/jump')
            ;
    }

    /**
     * @param string $message
     * @return Response
     */
    protected function onJumper($message='jumped')
    {
        return $this->redirect()
            ->withFlashData('flashed', 'this is via flash: '.$message)
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
            ->asView('controller/forms');
    }

    /**
     * @return Response
     */
    protected function onCreate()
    {
        return $this->respond()
            ->with('name', 'anonymous')
            ->asView('controller/create');
    }

    /**
     * @return Response
     */
    protected function onInsert()
    {
        if(!$this->validator->validate($this->request->getParsedBody())) {
            return $this->redirect()
                ->withInput($this->validator->getData())
                ->withInputErrors($this->validator->getErrors())
                ->withError('bad input.')
                ->toReferrer();
        }
        return $this->redirect()
            ->withInput($this->validator->getData())
            ->withMessage('good input.')
            ->toReferrer();
    }
}
