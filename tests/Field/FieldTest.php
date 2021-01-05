<?php

namespace Streams\Core\Tests\Field;

use Tests\TestCase;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

class FieldTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testFieldInstance()
    {
        $name = Streams::make('testing.examples')->fields->get('name');

        $this->assertInstanceOf(Field::class, $name);
    }

    public function testRuleAccessors()
    {
        $name = Streams::make('testing.examples')->fields->get('name');
        
        $this->assertTrue($name->hasRule('required'));
        $this->assertTrue($name->hasRule('min'));

        $this->assertEquals('min:3', $name->getRule('min'));
        
        $this->assertEquals(['3'], $name->getRuleParameters('min'));
        
        $this->assertTrue($name->isRequired());
    }
}
