<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Traits\EventableTrait;
use Streams\Platform\Traits\CommandableTrait;
use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Addon\Module\Event\ModuleWasInstalledEvent;
use Streams\Platform\Addon\Module\Event\ModuleWasUninstalledEvent;

class ModuleService
{
    use EventableTrait;
    use CommandableTrait;
    use DispatchableTrait;

    /**
     * The module class translator.
     *
     * @var ModuleTranslator
     */
    protected $translator;

    /**
     * Create a new ModuleService instance.
     *
     * @param ModuleTranslator $translator
     */
    public function __construct(ModuleTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Install a module.
     *
     * @param ModuleAbstract $module
     * @return bool
     */
    public function install(ModuleAbstract $module)
    {
        $installer = $this->translator->toInstaller($module);

        foreach ((new $installer)->getInstallers() as $installer) {
            app()->make($installer)->install();
        }

        $this->raise(new ModuleWasInstalledEvent($module));

        $this->dispatchEventsFor($this);

        $module->fire('after_install');

        return true;
    }

    /**
     * Uninstall a module.
     *
     * @param ModuleAbstract $module
     * @return bool
     */
    public function uninstall(ModuleAbstract $module)
    {
        $installer = $this->translator->toInstaller($module);

        foreach ((new $installer)->getInstallers() as $installer) {
            app()->make($installer)->uninstall();
        }

        $this->raise(new ModuleWasUninstalledEvent($module));

        $this->dispatchEventsFor($this);

        $module->fire('after_uninstall');

        return true;
    }
}
 