<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultProperties.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Command
 */
class SetDefaultProperties implements SelfHandling
{
    /**
     * The control panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultProperties instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function __construct(ControlPanelBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param ModuleCollection $modules
     */
    public function handle(ModuleCollection $modules)
    {
        $module = $modules->active();

        // No module, skip it.
        if (! $module) {
            return;
        }

        /*
         * Set the default sections handler based
         * on the active module. Defaulting to
         * no handler.
         */
        if (! $this->builder->getSections()) {
            $sections = get_class($module).'Sections';

            if (class_exists($sections)) {
                $this->builder->setSections($sections.'@handle');
            }
        }

        /*
         * Next use the module to
         * set sections directly.
         */
        if (! $this->builder->getSections()) {
            $this->builder->setSections($module->getSections());
        }
    }
}
