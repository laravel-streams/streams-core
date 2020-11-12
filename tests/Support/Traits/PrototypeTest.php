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
        
        $prototype->setPrototypeAttributes($prototype->getOriginalPrototypeAttributes());

        $this->assertTrue($prototype->name === 'Original');
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
