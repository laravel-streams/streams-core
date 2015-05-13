<?php namespace Anomaly\Streams\Platform\Field\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

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
     * The related stream namespace.
     *
     * @var null|string
     */
    protected $namespace = null;

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
     * Build the table.
     *
     * @param null $namespace
     */
    public function build($namespace = null)
    {
        if ($namespace) {
            $this->setNamespace($namespace);
        }

        parent::build();
    }

    /**
     * Make the table.
     *
     * @param null $namespace
     */
    public function make($namespace = null)
    {
        if ($namespace) {
            $this->setNamespace($namespace);
        }

        parent::make();
    }

    /**
     * Render the table.
     *
     * @return Response
     */
    public function render($namespace = null)
    {
        if ($namespace) {
            $this->setNamespace($namespace);
        }

        return parent::render();
    }

    /**
     * Limit to the stream's namespace.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $query
            ->where('namespace', $this->getNamespace())
            ->where('locked', 'false');
    }

    /**
     * Get the namespace.
     *
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the namespace.
     *
     * @param $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }
}
