<?php

namespace Streams\Core\Tests\Support;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Streams\Core\Stream\Stream;
use Illuminate\Routing\Controller;
use Streams\Core\Support\Provider;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Streams\Core\View\ViewOverrides;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Includes;
use Streams\Core\Support\Facades\Integrator;
use Illuminate\Routing\Route as RouteInstance;

class IntegratorTest extends TestCase
{

    public function test_can_integrate_array_of_details()
    {
        Integrator::integrate([
            'locale' => 'de',
        ]);

        $this->assertSame('de', App::getLocale());
    }

    public function test_can_set_app_locale()
    {
        Integrator::locale('de');

        $this->assertSame('de', App::getLocale());
    }

    public function test_can_set_config_values()
    {
        Integrator::config([
            'app.name' => 'Streams Testing',
        ]);

        $this->assertSame('Streams Testing', Config::get('app.name'));
    }

    public function test_can_register_assets()
    {
        Integrator::assets([
            'styles.css',
        ]);

        Assets::load('styles', 'styles.css');

        $this->assertEquals(['styles.css' => 'styles.css'], Assets::collection('styles')->all());
    }

    public function test_can_register_aliases()
    {
        Integrator::aliases([
            'CustomIntegratorImplementation' => CustomIntegratorService::class,
        ]);

        $this->assertSame(CustomIntegratorService::class, App::getAlias('CustomIntegratorImplementation'));
    }

    public function test_can_register_bindings()
    {
        Integrator::bindings([
            'TestCustomBinding' => CustomIntegratorService::class,
        ]);

        $this->assertInstanceOf(CustomIntegratorService::class, App::make('TestCustomBinding'));
    }

    public function test_can_register_singletons()
    {
        Integrator::singletons([
            'TestCustomBinding' => CustomIntegratorService::class,
        ]);

        $this->assertInstanceOf(CustomIntegratorService::class, App::make('TestCustomBinding'));
    }

    public function test_can_register_artisan_commands()
    {
        Integrator::commands([
            CustomArtisanCommand::class,
        ]);

        $this->assertTrue(Arr::has(Artisan::all(), 'custom-artisan-command'));
    }

    public function test_can_register_event_listeners()
    {
        Integrator::listeners([
            'custom-testing-event' => [
                CustomIntegratorListener::class,
            ],
        ]);

        $this->expectOutputString('Fired!');

        event('custom-testing-event');
    }

    public function test_can_register_policies()
    {
        $user = new CustomTestingUser(['name' => 'Ryan']);

        $this->be($user);

        Integrator::policies([
            'custom-testing-array-policy' => [CustomTestingPolicy::class, 'test'],
            'custom-testing-invokable-policy' => CustomInvokablePolicy::class,
            'custom-testing-closure-policy' => function() {
                return true;
            },
            CustomIntegratorService::class => CustomTestingPolicy::class,
        ]);

        $this->assertTrue(Gate::allows('custom-testing-array-policy'));
        $this->assertTrue(Gate::allows('custom-testing-closure-policy'));
        $this->assertTrue(Gate::allows('custom-testing-invokable-policy'));
        $this->assertTrue(Gate::allows('viewAny', new CustomIntegratorService));
    }

    public function test_can_register_routes()
    {
        Integrator::routes([
            'web' => [
                'foo/bar' => [
                    'as' => 'testing.foo',
                    'uses' => CustomTestingController::class,
                ],
            ],
        ]);

        $this->assertInstanceOf(RouteInstance::class, Route::getRoutes()->getByName('testing.foo'));
    }
    
    public function test_can_register_service_providers()
    {
        Integrator::providers([
            CustomTestingSecondaryProvider::class,
        ]);

        $this->assertInstanceOf(CustomIntegratorService::class, App::make('TestCustomProviderBinding'));
    }

    public function test_can_register_view_includes()
    {
        Integrator::includes([
            'slot' => [
                'welcome.blade.php',
            ],
        ]);

        $this->assertTrue(Includes::slot('slot')->contains('welcome.blade.php'));
    }

    public function test_can_register_view_overrides()
    {
        Integrator::overrides([
            'welcome.blade.php' => 'override.blade.php',
        ]);

        $this->assertSame('override.blade.php', app(ViewOverrides::class)->get('welcome.blade.php'));
    }

    public function test_can_register_streams()
    {
        Integrator::streams([
            'testing.array.stream' => [
                'name' => 'Testing Array Stream',
            ],
            base_path('vendor/streams/core/tests/litmus.json'),
        ]);

        $this->assertSame('Testing Array Stream', Streams::make('testing.array.stream')->name);
        $this->assertInstanceOf(Stream::class, Streams::make('testing.litmus'));
    }
}

class CustomIntegratorService
{
}

class CustomArtisanCommand extends Command
{
    protected $signature = 'custom-artisan-command';
}

class CustomIntegratorListener
{
    public function handle()
    {
        echo 'Fired!';
    }
}

class CustomInvokablePolicy
{
    public function __invoke()
    {
        return true;
    }
}

class CustomTestingPolicy
{
    public function test()
    {
        return true;
    }
    
    public function viewAny()
    {
        return true;
    }
}

class CustomTestingUser extends User
{
    protected $fillable = ['name'];
}

class CustomTestingController extends Controller
{
    public function __invoke()
    {
    }
}

class CustomTestingSecondaryProvider extends Provider
{

    public function register()
    {
        Integrator::bindings([
            'TestCustomProviderBinding' => CustomIntegratorService::class,
        ]);
    }
}