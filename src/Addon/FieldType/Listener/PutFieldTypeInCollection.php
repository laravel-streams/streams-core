<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Listener;

use Anomaly\Streams\Platform\Addon\FieldType\Event\FieldTypeWasRegistered;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;

/**
 * Class PutFieldTypeInCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType\Listener
 */
class PutFieldTypeInCollection
{

    /**
     * The fieldType collection.
     *
     * @var FieldTypeCollection
     */
    protected $fieldTypes;

    /**
     * Create a new PutFieldTypeInCollection instance.
     *
     * @param FieldTypeCollection $fieldTypes
     */
    public function __construct(FieldTypeCollection $fieldTypes)
    {
        $this->fieldTypes = $fieldTypes;
    }

    /**
     * Handle the event.
     *
     * @param FieldTypeWasRegistered $event
     */
    public function handle(FieldTypeWasRegistered $event)
    {
        $fieldType = $event->getFieldType();

        $this->fieldTypes->put(get_class($fieldType), $fieldType);
    }
}
