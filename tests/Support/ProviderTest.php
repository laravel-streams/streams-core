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
use Illuminate\Support\Facades\Artisan;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Includes;
use Streams\Core\Support\Facades\Integrator;
use Illuminate\Routing\Route as RouteInstance;

class ProviderTest extends TestCase
{

    public function setUp(): void
    {
        parent::createApplication();

        Integrator::providers([
            CustomTestingSecondaryProvider::class,
        ]);
    }

    public function test_can_register_assets()
    {
        Assets::load('styles', 'styles.css');

        $this->assertEquals(['styles.css' => 'styles.css'], Assets::collection('styles')->all());
    }

    // public function test_can_register_aliases()
    // {
    //     $this->assertSame(CustomProviderService::class, App::getAlias('CustomProviderImplementation'));
    // }

    public function test_can_register_bindings()
    {
        $this->assertInstanceOf(CustomProviderService::class, App::make('TestCustomBinding'));
    }

    public function test_can_register_singletons()
    {
        $this->assertInstanceOf(CustomProviderService::class, App::make('TestCustomBinding'));
    }

    public function test_can_register_artisan_commands()
    {
        $this->assertTrue(Arr::has(Artisan::all(), 'custom-artisan-command'));
    }

    public function test_can_register_event_listeners()
    {
        $this->expectOutputString('Fired!');

        event('custom-testing-event');
    }

    public function test_can_register_policies()
    {
        $user = new CustomTestingUser(['name' => 'Ryan']);

        $this->be($user);

        $this->assertTrue(Gate::allows('custom-testing-array-policy'));
        $this->assertTrue(Gate::allows('custom-testing-invokable-policy'));
        $this->assertTrue(Gate::allows('viewAny', new CustomProviderService));
    }

    public function test_can_register_routes()
    {
        $this->assertInstanceOf(RouteInstance::class, Route::getRoutes()->getByName('testing.foo'));
    }

    public function test_can_register_view_includes()
    {
        $this->assertTrue(Includes::slot('slot')->contains('welcome.blade.php'));
    }

    public function test_can_register_view_overrides()
    {
        $this->assertSame('override.blade.php', app(ViewOverrides::class)->get('welcome.blade.php'));
    }

    public function test_can_register_streams()
    {
        $this->assertSame('Testing Array Stream', Streams::make('testing.array.stream')->name);
        $this->assertInstanceOf(Stream::class, Streams::make('testing.litmus'));
    }
}

class CustomProviderService
{
}

class CustomArtisanCommand extends Command
{
    protected $signature = 'custom-artisan-command';
}

class CustomProviderListener
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

    public $assets = [
        'styles.css',
    ];

    // public $aliases = [
    //     'CustomProviderImplementation' => CustomProviderService::class,
    // ];

    public $bindings = [
        'TestCustomBinding' => CustomProviderService::class,
    ];

    public $singletons = [
        'TestCustomBinding' => CustomProviderService::class,
    ];

    public $routes = [
        'web' => [
            'foo/bar' => [
                'as' => 'testing.foo',
                'uses' => CustomTestingController::class,
            ],
        ],
    ];

    public $commands = [
        CustomArtisanCommand::class,
    ];

    public $listeners = [
        'custom-testing-event' => [
            CustomProviderListener::class,
        ],
    ];

    public $policies = [
        'custom-testing-array-policy' => [CustomTestingPolicy::class, 'test'],
        'custom-testing-invokable-policy' => CustomInvokablePolicy::class,
        CustomProviderService::class => CustomTestingPolicy::class,
    ];

    public $includes = [
        'slot' => [
            'welcome.blade.php',
        ],
    ];

    public $overrides = [
        'welcome.blade.php' => 'override.blade.php',
    ];

    public $streams = [
        'testing.array.stream' => [
            'name' => 'Testing Array Stream',
        ],
        'vendor/streams/core/tests/litmus.json',
    ];
}
