<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;

class ModuleCollectionTest extends TestCase
{

    /**
     * @todo confirm that ModuleCollection does not have a search functionality (as it does not use composer keys)
     */
    public function testSearch()
    {
        $this->markTestSkipped();
        $addons = app(ModuleCollection::class);

        $this->assertTrue($addons->search('anomaly.module.users::authenticator.*')->isNotEmpty());
    }
}
