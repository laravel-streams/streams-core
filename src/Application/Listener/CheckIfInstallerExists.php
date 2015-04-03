<?php namespace Anomaly\Streams\Platform\Application\Listener;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Message\MessageBag;
use Illuminate\Config\Repository;

/**
 * Class CheckIfInstallerExists
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Listener
 */
class CheckIfInstallerExists
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * Create a new CheckIfInstallerExists instance.
     *
     * @param Repository       $config
     * @param ModuleCollection $modules
     * @param MessageBag       $messages
     */
    public function __construct(Repository $config, ModuleCollection $modules, MessageBag $messages)
    {
        $this->config   = $config;
        $this->modules  = $modules;
        $this->messages = $messages;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        if (!$this->config->get('app.debug') && $this->modules->get('anomaly.module.installer')) {
            $this->messages->error('streams::message.delete_installer');
        }
    }
}
