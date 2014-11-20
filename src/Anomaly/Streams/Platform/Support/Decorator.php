<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Support\Collection;

/**
 * Class Decorator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Decorator
{

    /**
     * Decorate a value.
     *
     * @param mixed $resource
     * @return mixed
     */
    public function decorate($value)
    {
        if ($value instanceOf EloquentModel) {

            $value = $this->decorateRelations($value);
        }

        if ($value instanceof PresentableInterface) {

            $value = $value->newPresenter();
        }

        return $value;
    }

    /**
     * Decorate model relationships.
     *
     * @param EloquentModel $resource
     * @return mixed
     */
    protected function decorateRelations(EloquentModel $resource)
    {
        foreach ($resource->getRelations() as $relationName => $model) {

            if ($model instanceOf Collection) {

                $model = $this->decorateCollection($model);

                $resource->setRelation($relationName, $model);
            } elseif ($model instanceof PresentableInterface) {

                $resource->setRelation($relationName, $model->newPresenter());
            } else {

                $resource->setRelation($relationName, $model);
            }
        }

        return $resource;
    }

    /**
     * Decorate a collection of resources.
     *
     * @param Collection $collection
     * @return Collection
     */
    protected function decorateCollection(Collection $collection)
    {
        foreach ($collection as $resource) {

            if ($resource instanceof PresentableInterface) {

                // TODO: Translations fuck this up..
                //$collection->put($resource, $resource->newPresenter());
            }
        }

        return $collection;
    }
}