<?php namespace Streams\Platform\Support;

use Streams\Platform\Model\EloquentModel;
use Streams\Platform\Contract\PresenterInterface;

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

        if ($value instanceof PresenterInterface) {
            return $value->newPresenter($value);
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
            } else {
                $resource->setRelation($relationName, $model->newPresenter($model));
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
            $collection->put($resource, $resource->newPresenter($resource));
        }

        return $collection;
    }
}