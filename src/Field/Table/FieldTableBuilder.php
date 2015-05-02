<?php namespace Anomaly\Streams\Platform\Field\Table;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldTableBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Table
 */
class FieldTableBuilder extends TableBuilder
{

    /**
     * The related stream.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

    /**
     * The table model.
     *
     * @var string
     */
    protected $model = 'Anomaly\Streams\Platform\Field\FieldModel';

    /**
     * The table columns.
     *
     * @var array
     */
    protected $columns = [
        [
            'heading' => 'streams::field.name.name',
            'value'   => 'entry.name'
        ],
        [
            'heading' => 'streams::field.slug.name',
            'value'   => 'entry.slug'
        ],
        [
            'heading' => 'streams::field.type.name',
            'wrapper' => '{value}::addon.name',
            'value'   => 'entry.type'
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
        'delete'
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'order_by' => ['slug' => 'ASC']
    ];

    /**
     * Limit to the stream's namespace.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $query->where('namespace', $this->getStreamNamespace());
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

    /**
     * Get the stream namespace.
     *
     * @return string
     */
    public function getStreamNamespace()
    {
        return $this->stream->getNamespace();
    }
}
