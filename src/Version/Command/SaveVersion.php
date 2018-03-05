<?php namespace Anomaly\Streams\Platform\Version\Command;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Version\Contract\VersionRepositoryInterface;

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
     */
    public function handle(VersionRepositoryInterface $versions)
    {
        if (!$this->model->isVersionable()) {
            return;
        }

        if ($this->model->shouldVersion()) {
            $versions->create(
                [
                    'versionable' => $this->model,
                    'data'        => serialize($this->model->getAttributes()),
                ]
            );
        }
    }

}
