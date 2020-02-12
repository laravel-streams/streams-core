<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;

class ModuleCollectionTest extends TestCase
{

    public function testSearch()
    {
        $addons = app(ModuleCollection::class);

        $this->assertTrue($addons->search('anomaly.module.users::authenticator.*')->isNotEmpty());
    }
}
