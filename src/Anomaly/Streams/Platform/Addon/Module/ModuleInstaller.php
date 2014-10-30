<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Traits\CallableTrait;

class ModuleInstaller
{

    /**
     * Installers to run.
     *
     * @var array
     */
    protected $installers = [];

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
