<?php namespace Anomaly\Streams\Platform\Application\Listener;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Message\MessageBag;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

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
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

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
     * @param Request          $request
     * @param Store            $session
     * @param ModuleCollection $modules
     * @param MessageBag       $messages
     */
    public function __construct(
        Repository $config,
        Request $request,
        Store $session,
        ModuleCollection $modules,
        MessageBag $messages
    ) {
        $this->config   = $config;
        $this->request  = $request;
        $this->session  = $session;
        $this->modules  = $modules;
        $this->messages = $messages;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        if (
            !$this->config->get('app.debug') &&
            !$this->session->get(__CLASS__ . 'warned') &&
            $this->request->path() == 'admin/dashboard' &&
            $this->modules->get('anomaly.module.installer')
        ) {
            $this->session->set(__CLASS__ . 'warned', true);
            $this->messages->error('streams::message.delete_installer');
        }
    }
}
