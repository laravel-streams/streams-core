<?php

namespace Streams\Core\Tests\Field;

use Tests\TestCase;
use Streams\Core\Field\Field;
use Streams\Core\Field\FieldCollection;
use Streams\Core\Support\Facades\Streams;

class FieldCollectionTest extends TestCase
{

    public function testFieldInstance()
    {
        Streams::load(__DIR__ . '/../litmus.json');
        
        $this->assertInstanceOf(FieldCollection::class, Streams::make('testing.examples')->fields);
    }
    
    public function testGet()
    {
        $this->assertInstanceOf(Field::class, Streams::make('testing.examples')->fields->name);
    }
}
