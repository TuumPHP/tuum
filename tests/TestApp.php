<?php
namespace tests;

use Aura\Session\SessionFactory;
use Tuum\Web\Application;
use Tuum\Web\Psr7\RequestFactory;
use Tuum\Web\Psr7\Response;

abstract class TestApp extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    public $app;

    /**
     * @return string
     */
    abstract function getAppLocation();

    function setup()
    {
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
        $config = call_user_func(include(dirname(__DIR__).'/app/config.php'));
        $config['vars_dir'] .= '/tests';
        $this->app = call_user_func(include($this->getAppLocation()), $config);
    }

    /**
     * @param string $path
     * @param string $method
     * @return \Tuum\Web\Psr7\Request
     */
    function request($path, $method='get')
    {
        return RequestFactory::fromPath($path, $method)
            ->withSession((new SessionFactory)->newInstance([]))
            ->withApp($this->app);
    }

    /**
     * @param string $method
     * @param string $path
     * @return null|Response
     */
    function call($path, $method='get')
    {
        return $this->app->__invoke(
            $this->request($path, $method)
        );
    }
}