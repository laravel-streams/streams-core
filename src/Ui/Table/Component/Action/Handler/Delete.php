<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Application;

/**
 * Class DeleteActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Delete
{

    /**
     * The authentication guard.
     *
     * @var Guard
     */
    protected $guard;

    /**
     * The application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Delete instance.
     *
     * @param Guard       $guard
     * @param Application $application
     */
    public function __construct(Guard $guard, Application $application)
    {
        $this->guard       = $guard;
        $this->application = $application;
    }

    /**
     * Save the order of the entries.
     *
     * @param Table $table
     * @param array $selected
     */
    public function handle(Table $table, array $selected)
    {
        $model   = $table->getModel();
        $actions = $table->getActions();

        $action     = $actions->active();
        $user       = $this->guard->getUser();
        $permission = $action->getPermission();

        if ($user instanceof UserInterface && $permission && !$user->hasPermission($permission)) {
            $this->application->abort(403, "You do not have permission to perform this action [{$action->getSlug()}].");
        }

        $this->deleteEntries($model, $selected);

        $table->setResponse(redirect(app('request')->fullUrl()));
    }

    /**
     * Delete the entries.
     *
     * @param EloquentModel $model
     * @param array         $selected
     */
    protected function deleteEntries(EloquentModel $model, array $selected)
    {
        foreach ($selected as $id) {
            if ($entry = $model->find($id)) {
                $entry->delete();
            }
        }
    }
}
