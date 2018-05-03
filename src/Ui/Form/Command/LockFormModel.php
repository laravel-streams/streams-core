<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Lock\Contract\LockInterface;
use Anomaly\Streams\Platform\Lock\Contract\LockRepositoryInterface;
use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

/**
 * Class LockFormModel
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class LockFormModel
{

    /**
     * The table builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultOptions instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param LockRepositoryInterface $locks
     * @param MessageBag              $messages
     * @param Request                 $request
     * @param Store                   $session
     * @param Guard                   $auth
     */
    public function handle(
        LockRepositoryInterface $locks,
        MessageBag $messages,
        Request $request,
        Store $session,
        Guard $auth
    ) {

        /**
         * If the form does not have a
         * model then we can't lock it.
         */
        if (!$entry = $this->builder->getFormEntry()) {
            return;
        }

        /**
         * Got to be a model!
         */
        if (!$entry instanceof EloquentModel) {
            return;
        }

        /**
         * If the entry is new then we
         * don't have anything to lock.
         */
        if (!$entry->getId()) {
            return;
        }

        $locks->cleanup();

        /* @var LockInterface|EloquentModel $lock */
        if (!$lock = $locks->findByLockable($entry)) {
            $lock = $locks->create(
                [
                    'created_by_id' => $auth->id(),
                    'lockable_id'   => $entry->getId(),
                    'lockable_type' => get_class($entry),
                    'session_id'    => $session->getId(),
                    'ip_address'    => $request->ip(),
                ]
            );
        }

        if ($lock->session_id == $session->getId()) {
            $lock->touch();
        }

        if ($lock->session_id !== $session->getId()) {

            $this->builder->setLock($lock);

            $this->builder->setLocked(true);
            $this->builder->setSave(false);
        }

        if (!$this->builder->hasParent() && $this->builder->isLocked()) {

            $messages->important('streams::message.form_is_locked');

            if (!$request->isMethod('post')) {
                //$messages->error('This content is being edited by another user.');
            }
        }
    }
}
