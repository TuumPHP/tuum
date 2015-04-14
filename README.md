TuumPHP Starter Repository
======

A starter repository for TuumPHP web site. 

TuumPHP is a basic (micro + view) web application framework inspired by clean middleware structure of StackPHP, simplicity of Slim Framework, and ease of development of Laravel. 

> tbh, I feel TuumPHP is a bit too complicated compared to Slim. 

### License

MIT lisense.

### required packages

TuumPHP uses following packages;

*   [Aura/Session](https://github.com/auraphp/Aura.Session),
*   [Phly/Http](https://github.com/phly/http),
*   [Psr/Http-message](https://github.com/php-fig/http-message),
*   [Monolog/Monolog](https://github.com/Seldaek/monolog),
*   [League/Container](https://github.com/thephpleague/container),
*   [League/Flysystem](https://github.com/thephpleague/flysystem),
*   [Filp/Whoops](https://github.com/filp/whoops).

Uses home grown [template view](https://github.com/TuumPHP/View) and [router](https://github.com/TuumPHP/Router) (;´д｀)

Getting Started
----

### system requirements

This repository requires PHP >= 5.6.0. 

### installation

use ```git``` and ```composer``` to install. 

```sh
git clone https://github.com/TuumPHP/tuum
cd tuum
composer install
cd public
php -S localhost:8888 index.php
```

> please make the ```var/``` directory writable to the server.

and access ```http://localhost:8888``` in a browser. 

### simple routing using closures

The directory, ```app/```, contains scripts and configurations to construct a web application. The ```app/routes.php``` file contains routes definitions. 

So, how about adding the following code, somewhere after ```// add routes``` comments?

```php
$routes->get( '/new', function($request) {
    /** @var Request $request */
    return $request->respond()
    	->asText('just added a new page!');
});
$routes->get( '/back', function($request) {
    /** @var Request $request */
    return $request->redirect()
    	->withMessage('just redirected back')
    	->toPath('/new');
});
```

and access ```http://localhost:8888/new```, you should see the text, and accessing ```http://localhost:8888/json``` should redirect back to the ```/new``` page with a message. 


Directory Structure
----

### Top Level

*   ```app/```: contains scripts and configurations to construct a web application. It also contains ```views/``` and ```documents/``` directory are here. 
*   ```public/```: a public directory for web. 
*   ```src/```: contains all the PHP classes. 
*   ```var/```: contains variables that are not under VCS, such as logs, data, and cached data. 

### app/ Directory

*   ```app.php```: main scripts for constructing and executing the web application. 
*   ```config.php```: main configuration array for the web application. defines the location of ```routes.php```, ```views/```, ```documents/```, etc.
*   ```routes.php```: main routes definitions. 
*   ```config/```: main configuration of application classes. enviroment specific definitions are under this directory. 
*   ```documents/```: a default directory for URL mapper files. 
*   ```utils/```: a utility scripts for app.php. 
*   ```views/```: a default directory for view templates. 

View and Controller
----

This section descrives how controller and view works by walking through the work flow for a URL: ```http://localhost:8800/sample/create```. 

### routes.php

The above URL is defined in the ```app/routes.php``` as:

```php
$routes
    ->any( '/sample{*}', SampleController::class)
    ->before(function($request, $next) {
        /** @var Request $request */
        /** @var callable $next */
        return $next? $next($request->withAttribute('current', 'controller')): null;
});
```

which implies that ```SampleController``` class will handle any path starting with '/sample'. 

The trailing ```{*}``` in the route pattern denotes that the router will set the base path to ```/sample``` and the remaing path will be used for matching a route. 

The route also defines a before filter using a closure which sets an attribute ```current``` to be ```'controller'```. This variable is used for the main menu in a layout view. The ```$request``` is returned back to the middleware chain by using ```$next``` callable. 

### SampleController.php

The ```SampleController``` class is at ```src/Site/SampleController.php```.

A controller class may extend ```Tuum\Web\Controller\AbstractController``` abstract class which provides some convenient functionality to controllers. (Yes, you do not have to extend the class by implementing ApplicationInterface). 

The ```Tuum\Web\Controller\RouteDispatchTrait``` provides a controller based dispatching based on local routes returned by ```getRoutes``` method. For this example, ```'get:/create'``` and ```'post:/create'``` specifies which method to use for the routes. 

> Please note that the local routes defined in this controller does not have so called ```BasePath```, which is ```/sample``` in this example, because the original routes uses ```{*}``` to match only the relavent part of the path. 

```php
class SampleController extends AbstractController 
{
    use RouteDispatchTrait;

    /**
     * @return array
     */
    protected function getRoutes() 
    {
        return [
            'get:/create'  => 'create',
            'post:/create' => 'insert',
        ];
    }
    // more methods to follow...
}
```

TuumPHP comes with ```League/Container``` package. For this example, a ```SampleValidator``` class is injected at the constructor. 

```php
class SampleController extends AbstractController
{
    use RouteDispatchTrait;
I
    /**
     * @var SampleValidator
     */
    private $validator;

    /**
     * @return SampleController
     */
    public function __construct(SampleValidator $validator)
    {
        $this->validator = $validator;
    }
    // more methods to follow...
}
```

> Please do not look at the SampleValidator code. The code in the validator class is a sample-only quality. TuumPHP does not come with Validation package, so it is mocked up as a sample. 

### SampleController::onCreate Method

The controller adds ```on``` at the front of a method. For ```'get:/create' => 'create'```, the ```onCreate``` method is invoked.  

```php
    /**
     * @return Response
     */
    protected function onCreate()
    {
        return $this->respond()
            ->with('name', 'anonymous')
            ->asView('sample/create');
    }
```

This method simply returns a response of a sample/create view at ```app/views/sample/create.php``` with a default name of 'anonymous'. We will examine the view file in details later on. 


### SampleController::onInsert Method

The ```onInsert``` method is far more complicated than create method. It returns a redirect response back to the create form. The redirect contains either of,

*   a success message if validation is successful, or 
*   an error messages and other necessary information.  

```php
    /**
     * @return Response
     */
    protected function onInsert()
    {
        if(!$this->validator->validate($this->request->getBodyParams())) {
            return $this->redirect()
                ->withInput($this->validator->getData())
                ->withInputErrors($this->validator->getErrors())
                ->withError('bad input.')
                ->toBasePath('/create');
        }
        return $this->redirect()
            ->withInput($this->validator->getData())
            ->withMessage('good input.')
            ->toBasePath('/create');
    }
```

> Again, please note that it returns to ```/create``` path with respect to a basePath. 
> The API must be familiar to many; very similar to that of Laravel 4.2 (the source of __inspiration__). 

In case of error, the redirect may have the following information:

*   ```withInput```: the original posted values,
*   ```withInputErrors```: the error messages associated to each input, and 
*   ```withError```: an overall error message to the user. 

> The information in the redirect is 1) stored as a session's flash data, 2) retrieved in the next session, 3) saved in ```$request``` as attributes, 4) copied to view response in ```respond()``` method, then finally 5) appears in the view template. 

### Create.php View

Last but not least, the most complicated part of the examination is here, the view template. 

The create form template is at ```app/views/sample/create.php```, which is an ugly pieace of code that inter-mingles PHP with HTML code. 

```php
<h1>Create Form</h1>
<form method="post" action="">
    <?= $view->data->hiddenTag('_token'); ?>
    
    <?=
    $view->forms->formGroup(
        $view->forms->label('you name', 'name'),
        '<input type="text" name="name" id="name" value="'
        .$view->input->get('name', $data->raw('name'))
        . '" placeholder="maybe your name" class="form-control"/>'
    );?>
    <?= $view->errors->get('name'); ?>
```

The view template is rendered using ```Tuum/View``` renderer, which focused only on managing layouts, sections, and blocks. The data in the view is in the $view variable. 

##### $view

The $view variable contains all the response data passed from the ```onCreate``` and ```onInsert``` methods. 

*   ```$view->message```: error and success messages, 
*   ```$view->errors```: validation error messages from ```onInsert```.
*   ```$view->input```: old input from ```onInsert```, 
*   ```$view->data```: contains data such as $name ('anonymous' for this example), 
*   ```$view->forms```: contains form generator with ```$view->input```.

##### $view->message

contains messages from controllers' ```withMessage```, ```withAlert```, or ```withError` methods. In this sample, the messages are rendered in the layout file. 

##### $view->errors

A container for validation error message from ```withInputErrors```. 

##### $view->data

A generic container for any data. This automatically escapes any string data: ```$data['name']```, ```$data->name```, and ```$data->get('name')```. The ```$data->raw('name')``` will return a raw value. 

##### $view->input

A container for original posted value via ```withInput``` method.  $input allows to access its original value using the HTML element's name like:

```php
$input->get('sns[twitter]')
```

The second argument is a default value when an original input is not defined:

```php
$input->get('name', $data->raw('name'))
```

##### $view->forms

A generic helper for building form elements. It also incorporates the ```$view->input``` above. For instance, 

```php
$forms->text('sns[facebook]')->class('form-control')->placeholder('whatever but must have @ in it')->id();
```

will output a ```input:[type=text]``` element, while accessing ```$view->input->raw('sns[facebook]')``` internaly. 


