<?php
namespace tests\App;

use Tuum\Web\Application;
use Tuum\Web\View\Value;

class AppTest extends \tests\TestApp
{

    /**
     * @return Application
     */
    function getAppLocation()
    {
        return dirname(dirname(__DIR__)).'/app/app.php';
    }

    function test0()
    {
        $this->assertEquals('Tuum\Web\Application', get_class($this->app));
    }

    /**
     * @test
     */
    function calling_root_returns_response()
    {
        $response = $this->call('/');
        $this->assertEquals('Tuum\Web\Psr7\Response', get_class($response));
        $this->assertEquals('Tuum\Web\View\ViewStream', get_class($response->getBody()));
        $html = (string) $response->getBody();
        $this->assertContains('<!-- Section: Jumbotron -->', $html);
        $this->assertContains('<!-- Content: index -->', $html);
    }

    /**
     * @test
     */
    function calling_notFound_returns_error()
    {
        $response = $this->call('/no-such-uri-should-exists-for-testing-notFound-error');
        $this->assertEquals(404, $response->getStatusCode());
        $html = (string) $response->getBody();
        $this->assertContains('<!-- error: not-found -->', $html);
        $this->assertContains('<h1>Not Found</h1>', $html);
    }

    /**
     * @test
     */
    function calling_post_without_token_returns_forbidden_error()
    {
        $response = $this->call('/test', 'post');
        $this->assertEquals(403, $response->getStatusCode());
        $html = (string) $response->getBody();
        $this->assertContains('<!-- error: forbidden -->', $html);
        $this->assertContains('<h1>Cannot Access File</h1>', $html);
    }

    /**
     * @test
     */
    function calling_redirect_with_message()
    {
        $request  = $this->request('/controller/jumper')->withQueryParams(['message' => 'jump-test']);
        $response = $this->app->__invoke($request);
        $this->assertEquals(302, $response->getStatusCode());
        $message = $response->getData(Value::MESSAGE);
        $this->assertEquals('jump-test', $message[0]['message']);
    }
}