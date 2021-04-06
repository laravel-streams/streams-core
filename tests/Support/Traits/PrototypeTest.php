<?php

namespace Streams\Core\Tests\Support\Traits;

use ArrayAccess;
use Tests\TestCase;
use Streams\Core\Field\Value\Value;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Traits\Prototype;

class PrototypeTest extends TestCase
{

    public function testSupportInterfaces()
    {
        $prototype = new TestPrototype();

        // $this->assertIsArray($prototype->toArray());
        // $this->assertJson($prototype->toJson());
        // $this->assertJson((string) $prototype);

        $this->assertTrue(isset($prototype['name']));
        $this->assertTrue($prototype['name'] === 'Original');
        
        $prototype['name'] = 'Test';

        $this->assertTrue($prototype['name'] === 'Test');
        
        unset($prototype['name']);

        $this->assertFalse(isset($prototype['name']));
    }

    public function testCanInstantiate()
    {
        $prototype = new TestPrototype();

        $this->assertTrue($prototype->hasPrototypeAttribute('name'));
        $this->assertTrue($prototype->name === 'Original');
    }

    public function testCanResetAttributes()
    {
        $prototype = new TestPrototype();

        $prototype->name = 'Testing';

        $this->assertTrue($prototype->name === 'Testing');

        $prototype->setPrototypeAttributes($prototype->getOriginalPrototypeAttributes());

        $this->assertTrue($prototype->name === 'Original');

        $this->assertTrue([
            'name' => 'Original',
            'description' => 'NONE',
            'price' => 0.0,
            'status' => null,
        ] === $prototype->getPrototypeAttributes());
    }

    public function testCanLoadAttributes()
    {
        $prototype = new TestPrototype();

        $this->assertTrue($prototype->name === 'Original');
        $this->assertTrue($prototype->description === 'NONE');

        $prototype->loadPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
        ]);

        $this->assertTrue($prototype->name === 'Testing');
        $this->assertTrue($prototype->description === 'TEST');
    }

    public function testCanSetAttributes()
    {
        $prototype = new TestPrototype();

        $this->assertTrue($prototype->name === 'Original');

        $prototype->setPrototypeAttributes([
            'name' => 'Testing',
        ]);

        $this->assertTrue($prototype->name === 'Testing');
    }

    public function testCanExpandAttributes()
    {
        $prototype = new TestPrototype();

        $value = $prototype->expandPrototypeAttribute('name');

        $this->assertInstanceOf(Value::class, $value);

        $value = $prototype->expandPrototypeAttribute('description');

        $this->assertSame('--', (string) $value);

        $this->assertInstanceOf(NumberValue::class, $prototype->expandPrototypeAttribute('price'));
        $this->assertInstanceOf(Value::class, $prototype->expandPrototypeAttribute('status'));
    }
}

class TestPrototype implements ArrayAccess
{
    use Prototype;

    protected function initializePrototypeTrait(array $attributes)
    {
        $attributes = array_merge([
            'name' => 'Original',
            'description' => 'None',
            'price' => 0.0,
            'status' => null,
        ], $attributes);

        $this->loadPrototypeProperties([
            'name' => [
                'type' => 'string',
            ],
        ]);

        return $this->setPrototypeAttributes($attributes);
    }

    public function setDescriptionAttribute($value)
    {
        return $this->setPrototypeAttributeValue('description', strtoupper($value));
    }

    public function expandDescriptionAttribute($value)
    {
        return new Value('--');
    }
}
