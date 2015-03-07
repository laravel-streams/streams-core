<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class RegisterModulesHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class RegisterModulesHandler
{

    /**
     * The module model.
     *
     * @var ModuleModel
     */
    protected $model;

    /**
     * The addon manager.
     *
     * @var AddonManager
     */
    protected $manager;

    /**
     * Create a new RegisterModulesHandler instance.
     *
     * @param ModuleModel  $model
     * @param AddonManager $manager
     */
    public function __construct(ModuleModel $model, AddonManager $manager)
    {
        $this->model   = $model;
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        if (env('installed')) {

            /* @var EloquentCollection $enabled */
            $enabled = $this->model->getEnabled()->lists('namespace');
        } else {
            $enabled = ['none'];
        }

        $this->manager->register('module', $enabled);
    }
}
