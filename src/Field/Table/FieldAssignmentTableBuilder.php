<?php namespace Anomaly\Streams\Platform\Field\Table;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FieldAssignmentTableBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Table
 */
class FieldAssignmentTableBuilder extends TableBuilder
{

    /**
     * The table model.
     *
     * @var string
     */
    protected $model = 'Anomaly\Streams\Platform\Assignment\AssignmentModel';

    /**
     * The table entries.
     *
     * @var string
     */
    protected $entries = 'Anomaly\Streams\Platform\Assignment\Table\FieldAssignmentTableBuilder@handle';

    /**
     * The table columns.
     *
     * @var array
     */
    protected $columns = [
        [
            'heading' => 'streams::field.name.name',
            'value'   => 'entry.field.name'
        ],
        [
            'heading' => 'streams::field.slug.name',
            'value'   => 'entry.field.slug'
        ],
        [
            'heading' => 'streams::field.type.name',
            'value'   => 'entry.field.type'
        ]
    ];

    /**
     * The table buttons.
     *
     * @var array
     */
    protected $buttons = [
        'edit'
    ];

    /**
     * The table actions.
     *
     * @var array
     */
    protected $actions = [
        'reorder',
        'delete'
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'sortable' => true
    ];

    /**
     * Fired after a row is deleted.
     *
     * @param AssignmentInterface      $entry
     * @param FieldRepositoryInterface $fields
     */
    public function onRowDeleted(AssignmentInterface $entry, FieldRepositoryInterface $fields)
    {
        $fields->delete($entry->getField());
    }
}
