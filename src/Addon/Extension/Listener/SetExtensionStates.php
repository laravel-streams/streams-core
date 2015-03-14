<?php namespace Anomaly\Streams\Platform\Addon\Extension\Listener;

use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionModel;

/**
 * Class SetExtensionStates
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class SetExtensionStates
{

    /**
     * The extension model.
     *
     * @var ExtensionModel
     */
    protected $model;

    /**
     * The loaded extensions.
     *
     * @var ExtensionCollection
     */
    protected $extensions;

    /**
     * Create a new SetExtensionStates instance.
     *
     * @param ExtensionCollection $extensions
     * @param ExtensionModel      $model
     */
    public function __construct(ExtensionCollection $extensions, ExtensionModel $model)
    {
        $this->model      = $model;
        $this->extensions = $extensions;
    }

    /**
     * Set the installed / enabled status of
     * all of the registered extensions.
     */
    public function handle()
    {
        $states = $this->model->where('installed', true)->get();

        $this->extensions->setStates($states->all());
    }
}
