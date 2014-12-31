<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Support\Collection;

/**
 * Class EntryHydrator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryHydrator
{

    /**
     * Set the values of many fields onto the entry.
     *
     * @param EntryInterface $entry
     * @param Collection     $fields
     */
    public function fill(EntryInterface $entry, Collection $fields)
    {
        foreach ($fields as $field) {
            $this->set($entry, $field);
        }
    }

    /**
     * Set the value of a field onto the entry.
     *
     * @param EntryInterface $entry
     * @param FieldType      $field
     */
    protected function set(EntryInterface $entry, FieldType $field)
    {
        // If the field doesn't exist.. ignore it.
        if ($entry->hasField($field->getField())) {
            $entry->{$field->getField()} = $field->getPostValue();
        }
    }
}
