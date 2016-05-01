# Controllers

- [Introduction](#introduction)
- [Basic Controllers](#basic-controllers)
    - [Public Controllers](#public-controllers)
    - [Admin Controllers](#admin-controllers)
    - [Base Controller](#base-controller)

<hr>

<a name="introduction"></a>
## Introduction

Controllers in PyroCMS work exactly the same as [controllers in Laravel](https://laravel.com/docs/5.1/controllers).

<hr>

<a name="basic-controllers"></a>
## Basic Controllers

PyroCMS comes with two basic controller variations. One for `public` use and one for `admin` use.

<a name="public-controllers"></a>
### Public Controllers

PyroCMS comes with a public controller to extend with your own. There is no authentication associated with this controller by default.

To create a public controller extend the `\Anomaly\Streams\Platform\Http\Controller\PublicController` with your own.

    <?php namespace Example\Http\Controller;

    use Anomaly\Streams\Platform\Http\Controller\PublicController;

    class ExampleController extends PublicController
    {
        // Your controller methods.
    }

<a name="admin-controllers"></a>
### Admin Controllers

PyroCMS also comes with an admin controller to extend with your own. By default this controller run's middleware to control `admin` access.

To create an admin controller extend the `\Anomaly\Streams\Platform\Http\Controller\AdminController` with your own.

    <?php namespace Example\Http\Controller;

    use Anomaly\Streams\Platform\Http\Controller\AdminController;

    class ExampleController extends AdminController
    {
        // Your controller methods.
    }

<a name="base-controller"></a>
### Base Controller

The base controller for PyroCMS comes with a small handful of resources to help keep your controller's nice and clean.

The following classes are set on the base controller and are always available.

    $this->container   = app();
    $this->request     = app('Illuminate\Http\Request');
    $this->redirect    = app('Illuminate\Routing\Redirector');
    $this->view        = app('Illuminate\Contracts\View\Factory');
    $this->events      = app('Illuminate\Contracts\Events\Dispatcher');
    $this->template    = app('Anomaly\Streams\Platform\View\ViewTemplate');
    $this->messages    = app('Anomaly\Streams\Platform\Message\MessageBag');
    $this->response    = app('Illuminate\Contracts\Routing\ResponseFactory');
    $this->breadcrumbs = app('Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection');

    $this->route = $this->request->route();

Now you can easily use them as needed in your own controller:

    public function example()
    {
        return $this->view->make('theme::example');
    }