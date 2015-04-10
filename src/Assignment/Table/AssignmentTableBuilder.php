<?php namespace Anomaly\Streams\Platform\Assignment\Table;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

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
     * The table model.
     *
     * @var string
     */
    protected $model = 'Anomaly\Streams\Platform\Assignment\AssignmentModel';

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
        'sortable' => true,
        'limit'    => 500,
        'eager'    => [
            'field'
        ]
    ];

    /**
     * Fired when the table starts querying.
     *
     * @param StreamRepositoryInterface $streams
     * @param Builder                   $query
     */
    public function onQuerying(StreamRepositoryInterface $streams, Builder $query)
    {
        $stream = $streams->findBySlugAndNamespace(
            $this->getOption('stream'),
            $this->getOption('namespace')
        );

        $assignments = $stream->getAssignments()->withoutFields($this->getOption('skip', []))->lists('id');

        $query->where('stream_id', $stream->getId())->whereIn('id', $assignments);
    }
}
