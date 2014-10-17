<?php namespace Streams\Addon\Module\Testable;

use Streams\Platform\Addon\Module\ModuleInstaller;

class TestableModuleInstaller extends ModuleInstaller
{
    protected $installers = [
        'Streams\Addon\Module\Testable\Installer\FooBarInstaller',
    ];
}
 