<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class FieldTypeSchema
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeSchema
{

    /**
     * The field type object.
     *
     * @var FieldType
     */
    protected $type;

    /**
     * Create a new FieldTypeSchema instance.
     *
     * @param FieldType $type
     */
    public function __construct(FieldType $type)
    {
        $this->type = $type;
    }

    /**
     * Add the field type column to the table.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function addColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        $table->{$this->type->getColumnType()}($this->type->getColumnName())->nullable(!$assignment->isRequired());

        if ($assignment->isUnique()) {
            $table->unique($this->type->getColumnName());
        }
    }

    /**
     * Drop the field type column from the table.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function dropColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        $table->dropColumn($this->type->getColumnName());
    }
}
