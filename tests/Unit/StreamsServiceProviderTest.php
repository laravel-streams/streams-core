<?php

use Anomaly\Streams\Platform\Asset\AssetPaths;
use Anomaly\Streams\Platform\Image\ImagePaths;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Model\Users\UsersUsersEntryModel;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;

class StreamsServiceProviderTest extends TestCase
{

    public function testRegistersSingletonOfComposerJson()
    {
        $this->assertTrue(isset(app('composer.json')['require']['anomaly/streams-platform']));
    }

    public function testRegistersSingletonOfComposerLock()
    {
        $this->assertTrue(isset(app('composer.lock')['packages']));
    }

    public function testCanRegisterAddonCollections()
    {
        $this->assertInstanceOf(AddonCollection::class, app('addon.collection'));
        $this->assertInstanceOf(ThemeCollection::class, app('theme.collection'));
        $this->assertInstanceOf(ModuleCollection::class, app('module.collection'));
        $this->assertInstanceOf(ExtensionCollection::class, app('extension.collection'));
        $this->assertInstanceOf(FieldTypeCollection::class, app('field_type.collection'));
    }

    public function testCanInitializeApplication()
    {
        $this->assertEquals(env('APP_REFERENCE', 'default'), application()->getReference());
    }

    public function testCanLoadStreamsConfiguration()
    {
        $this->assertTrue(is_array(config('streams::addons.types')));
    }

    public function testCanConfigureFileCacheStore()
    {
        $this->assertTrue(ends_with(config('cache.stores.file.path'), DIRECTORY_SEPARATOR . application()->getReference()));
    }

    public function testCanAutoloadEntryModels()
    {
        $this->assertTrue(class_exists(UsersUsersEntryModel::class));
    }

    public function testCanAddAssetNamespaces()
    {
        $paths = app(AssetPaths::class);

        $this->assertEquals(public_path(), $paths->getPath('public'));
        $this->assertEquals(resource_path(), $paths->getPath('shared'));
        $this->assertEquals(base_path('node_modules'), $paths->getPath('node'));
        $this->assertEquals(base_path('bower_components'), $paths->getPath('bower'));
        $this->assertEquals(application()->getAssetsPath(), $paths->getPath('asset'));
        $this->assertEquals(application()->getStoragePath(), $paths->getPath('storage'));
        $this->assertEquals(application()->getResourcesPath(), $paths->getPath('resources'));
        $this->assertEquals(application()->getAssetsPath('assets/downloads'), $paths->getPath('download'));
        $this->assertEquals(base_path('vendor/anomaly/streams-platform/resources'), $paths->getPath('streams'));
    }

    public function testCanAddImageNamespaces()
    {
        $paths = app(ImagePaths::class);

        $this->assertEquals(public_path(), $paths->getPath('public'));
        $this->assertEquals(resource_path(), $paths->getPath('shared'));
        $this->assertEquals(base_path('node_modules'), $paths->getPath('node'));
        $this->assertEquals(base_path('bower_components'), $paths->getPath('bower'));
        $this->assertEquals(application()->getAssetsPath(), $paths->getPath('asset'));
        $this->assertEquals(application()->getStoragePath(), $paths->getPath('storage'));
        $this->assertEquals(application()->getResourcesPath(), $paths->getPath('resources'));
        $this->assertEquals(base_path('vendor/anomaly/streams-platform/resources'), $paths->getPath('streams'));
    }
}
