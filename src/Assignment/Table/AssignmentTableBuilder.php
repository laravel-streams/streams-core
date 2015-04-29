<?php namespace Anomaly\Streams\Platform\Assignment\Table;

use Anomaly\Streams\Platform\Assignment\Table\Command\SetDefaultProperties;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
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
     * The table stream.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

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
            'wrapper' => '{value}::addon.name',
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
     * Build the table.
     */
    public function build()
    {
        $this->dispatch(new SetDefaultProperties($this));

        parent::build();
    }


    /**
     * Fired when the table starts querying.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $assignments = $this->stream->getAssignments()->withoutFields($this->getOption('skip', []))->lists('id');

        $query->where('stream_id', $this->stream->getId())->whereIn('id', $assignments);
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface|null
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the stream.
     *
     * @param StreamInterface $stream
     * @return $this
     */
    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }
}
