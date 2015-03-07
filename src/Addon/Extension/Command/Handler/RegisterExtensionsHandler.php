<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionModel;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class RegisterExtensionsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension\Command
 */
class RegisterExtensionsHandler
{

    /**
     * The extension model.
     *
     * @var ExtensionModel
     */
    protected $model;

    /**
     * The addon manager.
     *
     * @var AddonManager
     */
    protected $manager;

    /**
     * Create a new RegisterExtensionsHandler instance.
     *
     * @param AddonManager   $manager
     * @param ExtensionModel $model
     */
    public function __construct(AddonManager $manager, ExtensionModel $model)
    {
        $this->model   = $model;
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        if (env('INSTALLED')) {

            /* @var EloquentCollection $enabled */
            $enabled = $this->model->getEnabled()->lists('namespace');
        } else {
            $enabled = ['none'];
        }

        $this->manager->register('extension', $enabled);
    }
}
