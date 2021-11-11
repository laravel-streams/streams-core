<?php

namespace Streams\Core\Tests\Support;

use Tests\TestCase;
use Streams\Core\Support\Facades\Hydrator;

class HydratorTest extends TestCase
{

    public function test_can_extract_accessible_properties()
    {
        $data = Hydrator::dehydrate(new ExampleHydratableObject);

        $this->assertSame([
            'public_value' => 'Public Test',
            'protected' => 'Protected Test',
            'boolean' => false,
        ], $data);
    }
}

class ExampleHydratableObject
{
    public string $publicValue = 'Public Test';

    protected string $protected = 'Protected Test';
    
    protected bool $boolean = false;
    
    private string $private = 'Private Test';

    public function getPrivate()
    {
        return $this->private;
    }

    public function getProtected()
    {
        return $this->protected;
    }

    public function isBoolean()
    {
        return $this->boolean;
    }
}
