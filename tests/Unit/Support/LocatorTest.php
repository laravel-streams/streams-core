<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Support\Locator;
use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\UsersModule\User\UserModel;

class LocatorTest extends TestCase
{

    public function testCanLocateByClass()
    {
        $locator = app(Locator::class);

        $this->assertEquals('anomaly.module.users', $locator->locate(UserModel::class));
    }

    public function testCanLocateByHook()
    {
        $locator = app(Locator::class);

        $this->assertEquals('test', $locator->locate(new LocatorStub()));
    }

    /**
     * @todo Resolver instead?
     */
    public function testCanResolve()
    {
        $this->markTestIncomplete();
        $locator = app(Locator::class);
        
        $this->assertEquals(null, $locator->resolve(EntryModel::class));
        $this->assertEquals(app('anomaly.module.users'), $locator->resolve(UserModel::class));
    }
}

class LocatorStub
{
    use Hookable;

    public function __locate()
    {
        return 'test';
    }
}
