<?php

namespace Streams\Core\Tests\Support\Traits;

use Streams\Core\Field\Value\Value;
use Tests\TestCase;
use Streams\Core\Support\Traits\Prototype;

class PrototypeTest extends TestCase
{

    public function testCanInstantiate()
    {
        $prototype = new TestPrototype();

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

        $this->assertTrue((string) $value == '--');
    }
}

class TestPrototype
{
    use Prototype;

    protected function initializePrototype(array $attributes)
    {
        $attributes = array_merge([
            'name' => 'Original',
            'description' => 'None',
        ], $attributes);

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
