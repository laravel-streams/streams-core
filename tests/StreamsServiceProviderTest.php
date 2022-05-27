<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Tests\CoreTestCase;

class StreamsServiceProviderTest extends CoreTestCase
{
    public function test_it_registers_composer_json()
    {
        $this->assertIsArray(app('composer.json'));
    }

    public function test_it_registers_composer_lock()
    {
        $this->assertIsArray(app('composer.lock'));
    }
}
