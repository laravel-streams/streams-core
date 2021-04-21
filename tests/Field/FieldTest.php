<?php

namespace Streams\Core\Tests\Field;

use Tests\TestCase;
use Streams\Core\Field\Field;
use Streams\Core\Field\Type\Integer;
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

    public function testName()
    {
        $field = Streams::make('testing.examples')->fields->get('name');

        $this->assertEquals('Name', $field->name());
    }

    public function testType()
    {
        $field = Streams::make('testing.examples')->fields->get('age');

        $this->assertInstanceOf(Integer::class, $field->type());
    }

    public function testRuleAccessors()
    {
        $name = Streams::make('testing.examples')->fields->get('name');
        $age = Streams::make('testing.examples')->fields->get('age');
        
        $this->assertTrue($name->hasRule('required'));
        $this->assertTrue($name->hasRule('min'));

        $this->assertNull($name->getRule('max'));
        $this->assertEquals('min:3', $name->getRule('min'));

        $this->assertEquals(['3'], $name->ruleParameters('min'));
        $this->assertEquals('3', $name->ruleParameter('min'));
        $this->assertEquals([], $name->ruleParameters('max'));
        $this->assertEquals([], $age->ruleParameters('min'));
        
        $this->assertTrue($name->isRequired());
        $this->assertFalse($age->isRequired());
    }

    public function testSupportInterfaces()
    {
        $this->assertIsArray(Streams::make('testing.examples')->fields->get('name')->toArray());
        $this->assertJson(Streams::make('testing.examples')->fields->get('name')->toJson());
        $this->assertJson((string) Streams::make('testing.examples')->fields->get('name'));
        $this->assertJson(Streams::make('testing.examples')->fields->get('name')->jsonSerialize());
    }
}
