<?php namespace Anomaly\Streams\Platform\Assignment\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class AssignmentTableBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Table
 */
class AssignmentTableBuilder extends TableBuilder
{

    /**
     * The table entries.
     *
     * @var string
     */
    protected $entries = 'Anomaly\Streams\Platform\Assignment\Table\AssignmentTableBuilder@handle';

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
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'sortable' => true
    ];

}
