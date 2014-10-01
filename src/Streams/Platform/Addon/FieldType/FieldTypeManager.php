<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\AddonManager;
use Streams\Platform\Addon\Model\FieldTypeModel;
use Streams\Platform\Addon\Collection\FieldTypeCollection;

class FieldTypeManager extends AddonManager
{
    /**
     * The folder within addons locations to load field_types from.
     *
     * @var string
     */
    protected $folder = 'field_types';

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return new FieldTypeModel();
    }

    /**
     * Return a new collection instance.
     *
     * @param array $fieldTypes
     * @return null|FieldTypeCollection
     */
    protected function newCollection(array $fieldTypes = [])
    {
        return new FieldTypeCollection($fieldTypes);
    }
}
