<?php namespace Anomaly\Streams\Platform\Version\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;
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
     * @var EntryModel
     */
    protected $model;

    /**
     * Create a new SaveVersion instance.
     *
     * @param EntryModel $model
     */
    public function __construct(EntryModel $model)
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

        if (!$this->model->shouldVersion()) {
            return;
        }

        /**
         * Loop over the relations so we can
         * load them and their child relations.
         */
        foreach (array_map(
                     'camel_case',
                     $this->model
                         ->getRelationshipAssignments()
                         ->fieldSlugs()
                 ) as $relationship) {

            /**
             * Loop over the relations of the relations
             * so that we get two levels deep for type
             * pattern entry models with say, blocks.
             */
            foreach ($this->model
                         ->{camel_case($relationship)}()
                         ->getRelated()
                         ->getRelationshipAssignments()
                         ->fieldSlugs() as $deepRelationship) {

                /**
                 * If the target is a deeper relation
                 * then go ahead and load the deep
                 * relation at this time too.
                 *
                 * But no more!
                 *
                 * @todo We need a way to make this respond to FT instructions somehow.
                 *       Maybe a field type callback. That passes the entry itself to load on.
                 */
                if (($target = $this->model->{$relationship}) instanceof EloquentModel) {
                    $target->{$deepRelationship};
                }
            }
        }

        $versions->create(
            [
                'created_at'    => now('UTC'),
                'created_by_id' => auth()->id(),
                'versionable'   => $this->model,
                'ip_address'    => request()->ip(),
                'model'         => serialize($this->model),
                'data'          => serialize($this->model->versionedAttributeChanges()),
            ]
        );
    }

}
