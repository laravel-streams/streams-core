<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Support\Facades\Locator;
use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\UsersModule\User\UserModel;

class LocatorTest extends TestCase
{

    public function testCanLocateByClass()
    {
        $this->assertEquals('anomaly.module.users', Locator::locate(UserModel::class));
    }

    public function testCanLocateByHook()
    {
        $this->assertEquals('test', Locator::locate(new LocatorStub()));
    }

    public function testCanResolve()
    {
        $this->assertEquals(null, Locator::resolve(EntryModel::class));
        $this->assertEquals(app('anomaly.module.users'), Locator::resolve(UserModel::class));
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
