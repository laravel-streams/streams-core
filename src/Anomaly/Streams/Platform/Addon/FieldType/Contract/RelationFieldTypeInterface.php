<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Contract;

use Anomaly\Streams\Platform\Entry\EntryModel;

/**
 * Interface RelationFieldTypeInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType\Contract
 */
interface RelationFieldTypeInterface
{

    /**
     * Get the relation.
     *
     * @param EntryModel $model
     * @return mixed
     */
    public function getRelation(EntryModel $model);
}
