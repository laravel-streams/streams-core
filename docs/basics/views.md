# Views

- [Basic Usage](#basic-usage)
    - [Passing Data To Views](#passing-data-to-views)
    - [Sharing Data With All Views](#sharing-data-with-all-views)
- [View Composers](#view-composers)

<a name="basic-usage"></a>
## Basic Usage

Views contain the HTML served by your addons and separate your controller / application logic from your presentation logic. Views are stored in the `resources/views` directory of their respective addon.

A simple view might look something like this:

    <!-- View stored in addons/shared/anomaly/example-module/resources/views/greeting.twig -->
    <html>
        <body>
            <h1>Hello, {{ name }}</h1>
        </body>
    </html>

Since this view is stored at `addons/shared/anomaly/example-module/resources/views/greeting.php`, we may return it using the global `view` helper function and the addon's `namespace prefix` like so:

    Route::get('/', function ()    {
        return view('anomaly.module.example::greeting', ['name' => 'Ryan']);
    });

As you can see, the first argument passed to the `view` helper corresponds to the namespace of the addon the view resides in and the name of the view file in the `resources/views` directory of that addon. The second argument passed to helper is an array of data that should be made available to the view. In this case, we are passing the `name` variable, which is displayed in the view using Twig.

Of course, views may also be nested within sub-directories of the `resources/views` directory. "Dot" notation may be used to reference nested views. For example, if your view is stored at `resources/views/admin/profile.php`, you may reference it like so:

    return view('anomaly.module.example::admin.profile', $data);

#### Determining If A View Exists

If you need to determine if a view exists, you may use the `exists` method after calling the `view` helper with no arguments. This method will return `true` if the view exists on disk:

    if (view()->exists('anomaly.module.example::emails.customer')) {
        //
    }

When the `view` helper is called without arguments, an instance of `Illuminate\Contracts\View\Factory` is returned, giving you access to any of the factory's methods.

<a name="view-data"></a>
### View Data

<a name="passing-data-to-views"></a>
#### Passing Data To Views

As you saw in the previous examples, you may easily pass an array of data to views:

    return view('anomaly.module.example::greetings', ['name' => 'Victoria']);

When passing information in this manner, `$data` should be an array with key/value pairs. Inside your view, you can then access each value using it's corresponding key, such as `<?php echo $key; ?>`. As an alternative to passing a complete array of data to the `view` helper function, you may use the `with` method to add individual pieces of data to the view:

    $view = view('anomaly.module.example::greeting')->with('name', 'Victoria');

<a name="sharing-data-with-all-views"></a>
#### Sharing Data With All Views

Occasionally, you may need to share a piece of data with all views that are rendered by your application. You may do so using the view factory's `share` method. Typically, you would place calls to `share` within a service provider's `boot` method. You are free to add them to the `AppServiceProvider` or generate a separate service provider to house them:

    <?php

    namespace App\Providers;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot()
        {
            view()->share('key', 'value');
        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    }

<a name="view-composers"></a>
## View Composers

By default the Streams Application uses a simple view composer to decorate objects and collections going into the view. Objects implementing the `Robbo\Presenter\PresentableInterface` will be decorated by their presenter automatically when passed to a view.

For more information on view composers visit [Laravel's documentation](http://laravel.com/docs/5.1/views#view-composers) on the subject.