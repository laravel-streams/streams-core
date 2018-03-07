<?php namespace Anomaly\Streams\Platform\Version\Command;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Version\Contract\VersionRepositoryInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

/**
 * Class SaveVersion
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SaveVersion
{

    /**
     * The eloquent model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new SaveVersion instance.
     *
     * @param EloquentModel $model
     */
    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the command.
     *
     * @param VersionRepositoryInterface $versions
     * @param Request                    $request
     * @param Guard                      $auth
     */
    public function handle(VersionRepositoryInterface $versions, Request $request, Guard $auth)
    {
        if (!$this->model->isVersionable()) {
            return;
        }

        if ($this->model->shouldVersion()) {
            $versions->create(
                [
                    'created_at'    => now('UTC'),
                    'created_by_id' => $auth->id(),
                    'versionable'   => $this->model,
                    'ip_address'    => $request->ip(),
                    'model'         => serialize($this->model),
                    'data'          => serialize($this->model->getVersionedAttributeChanges()),
                ]
            );
        }
    }

}
