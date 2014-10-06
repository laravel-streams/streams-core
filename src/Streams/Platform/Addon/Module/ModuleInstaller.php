<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Traits\CallableTrait;

class ModuleInstaller
{
    use CallableTrait;

    /**
     * Installers to run.
     *
     * @var array
     */
    protected $installers = [];

    /**
     * Set the installers to run.
     *
     * @param $installers
     * @return $this
     */
    public function setInstallers($installers)
    {
        $this->installers = $installers;

        return $this;
    }

    /**
     * Get the installers to run.
     *
     * @return array
     */
    public function getInstallers()
    {
        return $this->installers;
    }
}
