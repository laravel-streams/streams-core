<?php

namespace Streams\Core\Tests\Support;

use Tests\TestCase;
use Illuminate\Support\Facades\App;
use Streams\Core\Support\Facades\Integrator;

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
}
