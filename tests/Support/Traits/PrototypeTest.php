<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Streams\Core\Support\Traits\Prototype;

class PrototypeTest extends TestCase
{

    public function testCanInstantiateWithOriginalAttributes()
    {
        $prototype = new TestPrototype();

        $prototype->name = 'Testing';

        
        $this->assertTrue($prototype->name === 'Testing');
        $this->assertTrue($prototype->getPrototypeAttribute('name') === 'Testing');
        
        $prototype->setPrototypeAttributes($prototype->getOriginalPrototypeAttributes());

        $this->assertTrue($prototype->name === 'Original');
        $this->assertTrue(['name' => 'Original'] === $prototype->getPrototypeAttributes());
    }

    public function testCanLoadAttributes()
    {
        $prototype = new TestPrototype();

        $this->assertTrue($prototype->name === 'Original');
        $this->assertNull($prototype->description);

        $prototype->loadPrototypeAttributes([
            'name' => 'Testing',
            'description' => 'Test',
        ]);

        $this->assertTrue($prototype->name === 'Testing');
        $this->assertTrue($prototype->description === 'Test');
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
}

class TestPrototype
{
    use Prototype {
        Prototype::initializePrototype as private initializeBasePrototype;
    }

    protected function initializePrototype(array $attributes)
    {
        $this->setPrototypeAttributes(array_merge([
            'name' => 'Original',
        ], $attributes));

        return $this->initializeBasePrototype([]);
    }
}
