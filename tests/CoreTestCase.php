<?php

namespace Streams\Core\Tests;

use Streams\Testing\TestCase;
use Streams\Core\StreamsServiceProvider;

abstract class CoreTestCase extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [StreamsServiceProvider::class];
    }
}
