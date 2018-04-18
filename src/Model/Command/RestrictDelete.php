<?php namespace Anomaly\Streams\Platform\Model\Command;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Translation\Translator;

/**
 * Class RestrictDelete
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RestrictDelete
{

    /**
     * The eloquent model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new RestrictDelete instance.
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
     * @param MessageBag $messages
     * @param Translator $translator
     *
     * @return bool
     */
    public function handle(MessageBag $messages, Translator $translator)
    {
        foreach ($this->model->getRestricts() as $relation) {

            $humanize = str_humanize($relation);

            /* @var Relation $relation */
            $relation = $this->model->{$relation}();

            if (method_exists($relation, 'withTrashed')) {
                $relation = $relation->withTrashed();
            }

            if ($relation->count()) {

                $messages->warning(
                    $translator->trans(
                        'streams::message.delete_restrict',
                        [
                            'relation' => $humanize,
                            'name'     => $this->model->getTitle(),
                        ]
                    )
                );

                return true;
            };
        }

        return false;
    }
}
