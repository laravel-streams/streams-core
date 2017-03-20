<?php

class ThemeCollectionTest extends TestCase
{

    public function testCanReturnActiveAdminTheme()
    {
        $collection = $this->app->make(\Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class);

        $this->assertInstanceOf(Anomaly\TestAdminTheme\TestAdminTheme::class, $collection->active('admin'));
    }

    public function testCanReturnActiveStandardTheme()
    {
        $collection = $this->app->make(\Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class);

        $this->assertInstanceOf(Anomaly\TestStandardTheme\TestStandardTheme::class, $collection->active('standard'));
    }

    public function testReturnsActiveCurrentByDefault()
    {
        $collection = $this->app->make(\Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class);

        $this->assertInstanceOf(Anomaly\TestStandardTheme\TestStandardTheme::class, $collection->active());
    }

    public function testCanReturnAdminThemes()
    {
        $collection = $this->app->make(\Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class);

        $this->assertNotNull($collection->admin()->get('anomaly.theme.test_admin'));
    }

    public function testCanReturnStandardThemes()
    {
        $collection = $this->app->make(\Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class);

        $this->assertNotNull($collection->standard()->get('anomaly.theme.test_standard'));
    }
}
