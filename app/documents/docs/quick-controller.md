Controller and View
=======

Let's find out how controller and view works by walking through the work flow for a URL:
 ```http://localhost:8800/sample/create```. 

This example is just a mock (no real database to store) but shows how to 

*   construct a controller,
*   return validation errors and messages back to the form,
*   show the error messages and values. 


routes.php
----

The above URL is defined in the ```app/config/routes.php``` as:

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

SampleController.php
----


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

SampleController::onCreate Method
----

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


SampleController::onInsert Method
----

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

Create.php Template
----

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

The view template is rendered using ```Tuum/View``` renderer, which focused only on managing layouts, sections, and blocks. The data in the view is in the ```$view``` variable. 

#### $view

The $view object is just a holder to keep following data and helper objects.

#### $view->data

The ```$view->data``` holds the data from the application and controller. This object is responsible for accessing data with escaping for HTML. 

#### $view->input

The ```$view->input``` holds the data redirected back from the controller (i.e. ```Input::old``` in Laravel). 

#### $view->errors

The ```$view->errors``` holds the validation error messages for each property. 


More Information
----

Following sections describes in details. 

*   Request and Response
*   Controller
*   View
*   Form Helpers
