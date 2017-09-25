<?php namespace Anomaly\Streams\Platform\Assignment\Table;

use Anomaly\Streams\Platform\Assignment\Table\Command\SetDefaultProperties;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AssignmentTableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
            'value'   => 'entry.field.name',
        ],
        [
            'heading' => 'streams::field.slug.name',
            'value'   => 'entry.field.slug',
        ],
        [
            'heading' => 'streams::field.type.name',
            'value'   => 'entry.field_type.title',
        ],
        [
            'value' => 'entry.labels',
        ],
    ];

    /**
     * The table buttons.
     *
     * @var array
     */
    protected $buttons = [
        'edit' => [
            'href' => '/{request.path}/edit/{entry.id}',
        ],
    ];

    /**
     * The table actions.
     *
     * @var array
     */
    protected $actions = [
        'reorder',
        'prompt',
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
            'field',
        ],
        'order_by' => [
            'sort_order' => 'ASC',
        ],
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
     * Fired when the builder is ready to build.
     *
     * @throws \Exception
     */
    public function onReady()
    {
        if (!$this->getStream()) {
            throw new \Exception('The $stream parameter is required.');
        }
    }

    /**
     * Fired when the table starts querying.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $locked      = $this->stream->getAssignments()->locked()->pluck('id')->all();
        $assignments = $this->stream->getAssignments()->withFields($this->getOption('skip', []))->pluck('id')->all();

        $query->where('stream_id', $this->stream->getId())->whereNotIn('id', array_merge($locked, $assignments));
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
     * @param  StreamInterface $stream
     * @return $this
     */
    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }
}
