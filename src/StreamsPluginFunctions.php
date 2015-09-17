<?php

namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\Plugin\PluginForm;
use Anomaly\Streams\Platform\Addon\Plugin\PluginQuery;
use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Decorator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class StreamsPluginFunctions.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsPluginFunctions
{
    /**
     * The plugin form utility.
     *
     * @var PluginForm
     */
    protected $form;

    /**
     * The plugin query utility.
     *
     * @var PluginQuery
     */
    protected $query;

    /**
     * The presenter decorator.
     *
     * @var Decorator
     */
    private $decorator;

    /**
     * Create a new StreamsPluginFunctions instance.
     *
     * @param PluginForm  $form
     * @param PluginQuery $query
     * @param Decorator   $decorator
     */
    public function __construct(PluginForm $form, PluginQuery $query, Decorator $decorator)
    {
        $this->form      = $form;
        $this->query     = $query;
        $this->decorator = $decorator;
    }

    /**
     * Return a paginated collection of entries.
     *
     * @param array $parameters
     * @return LengthAwarePaginator
     */
    public function paginated(array $parameters = [])
    {
        return $this->decorator->decorate($this->query->paginate($parameters));
    }

    /**
     * Return a collection of stream entries.
     *
     * @param array $parameters
     * @return EntryCollection
     */
    public function entries(array $parameters = [])
    {
        return $this->decorator->decorate($this->query->get($parameters));
    }

    /**
     * Return a single stream entry.
     *
     * @param array $parameters
     * @return EntryPresenter
     */
    public function entry(array $parameters = [])
    {
        return $this->decorator->decorate($this->query->first($parameters));
    }

    /**
     * Return a stream entry form.
     *
     * @param array $parameters
     * @return $this
     */
    public function form(array $parameters = [])
    {
        $builder = $this->form->make($parameters);

        return $this->decorator->decorate($builder->getForm());
    }
}
