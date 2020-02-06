<?php

namespace Anomaly\Streams\Platform\Entry\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeQuery;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Entry\EntryRouter;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\Contract\EloquentInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Interface EntryInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface EntryInterface extends EloquentInterface
{

    /**
     * Get the title.
     *
     * @return mixed
     */
    //public function getTitle();

    /**
     * Return the stream.
     *
     * @return StreamInterface
     */
    //public function stream();

    /**
     * Get a field value.
     *
     * @param        $fieldSlug
     * @param  null $locale
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null);

    /**
     * Set a field value.
     *
     * @param        $fieldSlug
     * @param        $value
     * @param  null $locale
     * @return $this
     */
    public function setFieldValue($fieldSlug, $value, $locale = null);

    /**
     * Eager load relations on the model.
     *
     * @param  $relations
     * @return $this
     */
    public function load($relations);

    /**
     * Return whether the model is being
     * force deleted or not.
     *
     * @return bool
     */
    public function isForceDeleting();

    /**
     * Return the last modified datetime.
     *
     * @return Carbon
     */
    public function lastModified();

    /**
     * Return a new presenter instance.
     *
     * @return EntryPresenter
     */
    public function newPresenter();

    // /**
    //  * Return a model route.
    //  *
    //  * @return string
    //  */
    // public function route($route, array $parameters = []);

    // /**
    //  * Return a new router instance.
    //  *
    //  * @return EntryRouter
    //  */
    // public function newRouter();

    // /**
    //  * Get the router.
    //  *
    //  * @return EntryRouter
    //  */
    // public function getRouter();

    /**
     * Get the router name.
     *
     * @return string
     */
    public function getRouterName();

    /**
     * Get the query builder name.
     *
     * @return string
     */
    public function getQueryBuilderName();

    /**
     * Return the entry with
     * relations as an array.
     *
     * @return array
     */
    public function toArrayWithRelations();

    /**
     * Return the routable array.
     *
     * @return array
     */
    public function toRoutableArray();

    /**
     * Fire field type events.
     *
     * @param       $trigger
     * @param array $payload
     */
    public function fireFieldTypeEvents($trigger, $payload = []);

    /**
     * Get the cascading actions.
     *
     * @return array
     */
    public function getCascades();

    /**
     * Return the creator relation.
     *
     * @return BelongsTo
     */
    public function createdBy();

    /**
     * Return the updater relation.
     *
     * @return BelongsTo
     */
    public function updatedBy();
}
