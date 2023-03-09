<?php

namespace Streams\Core\Tests\Entry;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Entry\EntryFactory;
use Streams\Core\Support\Facades\Streams;

class EntryFactoryTest extends CoreTestCase
{
    public function test_it_is_accessible_from_stream()
    {
        $this->assertInstanceOf(EntryFactory::class, Streams::factory('films'));
        $this->assertInstanceOf(EntryFactory::class, Streams::make('films')->factory());
    }
}
