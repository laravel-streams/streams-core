<?php

namespace Streams\Core\Tests;

use Streams\Testing\TestCase;

abstract class CoreTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Collective\Html\HtmlServiceProvider::class,
            \Streams\Core\StreamsServiceProvider::class,
        ];
    }
}
