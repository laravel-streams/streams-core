<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple\Command;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;

/**
 * Class HandleLocks
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HandleLocks
{

    /**
     * The multiple form builder.
     *
     * @var MultipleFormBuilder
     */
    protected $builder;

    /**
     * Create a new HandleLocks instance.
     *
     * @param MultipleFormBuilder $builder
     */
    public function __construct(MultipleFormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param MessageBag $messages
     * @param Repository $config
     * @param Guard $auth
     */
    public function handle(
        MessageBag $messages,
        Repository $config,
        Guard $auth
    ) {

        /**
         * If locking is disabled then skip it!
         */
        if ($config->get('streams::system.locking_enabled', true) == false) {
            return;
        }

        /**
         * We need a user to
         * continue for now.
         *
         * @var UserInterface $user
         */
        if (!$user = $auth->user()) {
            return;
        }

        $forms = $this->builder->getForms();

        $locked = $forms->locked();

        /**
         * None of the forms are locked.
         */
        if ($locked->isEmpty()) {
            return;
        }

        //$this->builder->setReadOnly(true);
        $this->builder->setLocked(true);
        $this->builder->setSave(false);

        $this->builder->setOption('locked', true);

        $messages->important(
            trans(
                'streams::lock.locked_by_user',
                [
                    'username' => $user->getUsername(),
                ]
            )
        );
    }
}
