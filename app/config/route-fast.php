<?php
use Tuum\Router\RouteCollector;
use Tuum\Web\Psr7\Request;
use Tuum\Web\Stack\RouterStack;
use Tuum\Web\Web;

/** @var Web $web */
/** @var RouterStack $stack */
/** @var RouteCollector $routes */

$stack  = $web->getRouterStack();
$routes = $stack->getRouting();

$routes->any('/*', function ($request) {
    /** @var Request $request */
    return $request->respond()->asHtml(<<<HTMLTAG

<!DOCTYPE html>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<style>
div#title {
    margin: 5em 2em 0 2em;
    font-family: 'Open Sans',sans-serif;
    text-align: center;
}
h1 {
    font-size: 70px;
    font-weight: 400;
    color: #bbbbbb;
}
p {
    font-family: 'Open Sans',sans-serif;
    font-weight: 300;
    font-size: 18px;
    color: #cccccc;
}
p.sub-title {
    font-size: 25px;
}
span.punch {
    font-weight: 700;
}
</style>
</head>
<body>
<div id='title'>
    <h1>Tuum framework</h1>
    <p class="sub-title">Yet-Another PHP Framework for Basic Web Site.</p>
    <p>'<span class="punch">tuum</span>' means '<i>yours</i>' in latin; it happens to be the same pronunciation as '<span class="punch">tsu-mu</span>' which means '<i>stack</i>' in Japanese.</p>
</div>
</body>
</html>
HTMLTAG
    );
});

return $stack;