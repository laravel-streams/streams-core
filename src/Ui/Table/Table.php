<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Form\FormPresenter;
use Anomaly\Streams\Platform\Traits\ProvidesJsonable;
use Anomaly\Streams\Platform\Traits\ProvidesArrayable;
use Anomaly\Streams\Platform\Ui\Table\Component\View\View;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderCollection;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Contract\RowInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface;

/**
 * Class Table
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Table
{

    use ProvidesJsonable;
    use ProvidesArrayable;

    /**
     * The table model.
     *
     * @var null|EloquentModel
     */
    protected $model = null;

    /**
     * The table repository.
     *
     * @var TableRepositoryInterface
     */
    protected $repository = null;

    /**
     * The table stream.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

    /**
     * The table content.
     *
     * @var null|string
     */
    protected $content = null;

    /**
     * The table response.
     *
     * @var null|Response
     */
    protected $response = null;

    /**
     * The table data.
     *
     * @var Collection
     */
    protected $data;

    /**
     * The table rows.
     *
     * @var RowCollection
     */
    protected $rows;

    /**
     * The table views.
     *
     * @var Component\View\ViewCollection
     */
    protected $views;

    /**
     * The table entries.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $entries;

    /**
     * The table filters.
     *
     * @var Component\Filter\FilterCollection
     */
    protected $filters;

    /**
     * The table options.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $options;

    /**
     * The table actions.
     *
     * @var Component\Action\ActionCollection
     */
    protected $actions;

    /**
     * The table headers.
     *
     * @var HeaderCollection
     */
    public $headers;

    /**
     * Create a new Table instance.
     *
     * @param Collection $data
     * @param Collection $options
     * @param Collection $entries
     * @param RowCollection $rows
     * @param ViewCollection $views
     * @param HeaderCollection $headers
     * @param ActionCollection $actions
     * @param FilterCollection $filters
     */
    public function __construct(
        Collection $data,
        Collection $options,
        Collection $entries,
        RowCollection $rows,
        ViewCollection $views,
        HeaderCollection $headers,
        ActionCollection $actions,
        FilterCollection $filters
    ) {
        $this->data    = $data;
        $this->rows    = $rows;
        $this->views   = $views;
        $this->actions = $actions;
        $this->entries = $entries;
        $this->headers = $headers;
        $this->filters = $filters;
        $this->options = $options;
    }

    /**
     * Set the table response.
     *
     * @param  null|Response $response
     * @return $this
     */
    public function setResponse(Response $response = null)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the table response.
     *
     * @return null|Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the model object.
     *
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model object.
     *
     * @return null|EloquentModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get the table repository.
     *
     * @return TableRepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Set the table repository.
     *
     * @param  TableRepositoryInterface $repository
     * @return $this
     */
    public function setRepository(TableRepositoryInterface $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Set the table stream.
     *
     * @param  StreamInterface $stream
     * @return $this
     */
    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the table stream.
     *
     * @return null|StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the table content.
     *
     * @param  string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the table content.
     *
     * @return null|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add an action to the action collection.
     *
     * @param  ActionInterface $action
     * @return $this
     */
    public function addAction(ActionInterface $action)
    {
        $this->actions->put($action->getSlug(), $action);

        return $this;
    }

    /**
     * Set the actions.
     *
     * @param  ActionCollection $actions
     * @return $this
     */
    public function setActions(ActionCollection $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get the actions.
     *
     * @return ActionCollection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Return if table has actions.
     *
     * @return boolean
     */
    public function hasActions()
    {
        return $this->actions->isNotEmpty();
    }

    /**
     * Add a filter to the filter collection.
     *
     * @param  FilterInterface $filter
     * @return $this
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters->put($filter->getSlug(), $filter);

        return $this;
    }

    /**
     * Set the table filters.
     *
     * @param  FilterCollection $filters
     * @return $this
     */
    public function setFilters(FilterCollection $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get the table filters.
     *
     * @return FilterCollection
     */
    public function getFilters()
    {
        return $this->filters;
    }


    /**
     * Return if the table has filters.
     *
     * @return boolean
     */
    public function hasFilters()
    {
        return $this->filters->isNotEmpty();
    }

    /**
     * Return a specific filter.
     *
     * @param $key
     * @return FilterInterface|null
     */
    public function getFilter($key)
    {
        return $this->filters->get($key);
    }

    /**
     * Set the table options.
     *
     * @param  Collection $options
     * @return $this
     */
    public function setOptions(Collection $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the table options.
     *
     * @return Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set an option.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options->put($key, $value);

        return $this;
    }

    /**
     * Get an option value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return $this->options->get($key, $default);
    }

    /**
     * Set the table entries.
     *
     * @param  Collection $entries
     * @return $this
     */
    public function setEntries(Collection $entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Get the table entries.
     *
     * @return Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Add a view to the view collection.
     *
     * @param  ViewInterface $view
     * @return $this
     */
    public function addView(ViewInterface $view)
    {
        $this->views->put($view->getSlug(), $view);

        return $this;
    }

    /**
     * Set the table views.
     *
     * @param  ViewCollection $views
     * @return $this
     */
    public function setViews(ViewCollection $views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get the table views.
     *
     * @return ViewCollection
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Get the active view.
     *
     * @return View
     */
    public function getActiveView()
    {
        return $this->views->active();
    }

    /**
     * Get the active view slug.
     * 
     * @return string
     */
    public function getActiveViewSlug()
    {
        if (!$view = $this->getActiveView()) {
            return;
        }

        return $view->getSlug();
    }

    /**
     * Return if table has views.
     *
     * @return boolean
     */
    public function hasViews()
    {
        return $this->views->isNotEmpty();
    }

    /**
     * Add data to the data collection.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->data->put($key, $value);

        return $this;
    }

    /**
     * Set the table data.
     *
     * @param  Collection $data
     * @return $this
     */
    public function setData(Collection $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the table data.
     *
     * @return Collection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Add a row to the row collection.
     *
     * @param  RowInterface $row
     * @return $this
     */
    public function addRow(RowInterface $row)
    {
        $this->rows->push($row);

        return $this;
    }

    /**
     * Set the table rows.
     *
     * @param  RowCollection $rows
     * @return $this
     */
    public function setRows(RowCollection $rows)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Get the table rows.
     *
     * @return RowCollection
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Return if the table has rows.
     *
     * @return bool
     */
    public function hasRows()
    {
        return $this->rows->isNotEmpty();
    }

    /**
     * Return a created presenter.
     *
     * @return FormPresenter
     */
    public function newPresenter()
    {
        $presenter = get_class($this) . 'Presenter';

        if (class_exists($presenter)) {
            return app()->make($presenter, ['object' => $this]);
        }

        return app()->make(TablePresenter::class, ['object' => $this]);
    }

    /**
     * Return attributes for the table.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge(
            $this->getOption('attributes', []),
            [
                // System attributes like sortable
            ],
            $attributes
        );
    }

    /**
     * Return a prefixed target.
     *
     * @param string $target
     * @return string
     */
    public function prefix($target = null)
    {
        return $this->getOption('prefix') . $target;
    }

    /**
     * Return the Vuetify data export. 
     *
     * @param array $data
     * @return array
     */
    public function toVuetify($data = [])
    {
        $data = [
            //singleSelect: false,
            //'selected' => [],
            'headers' => $this->headers->toVuetify(),
            // desserts: [
            //   [
            //     name: 'Frozen Yogurt',
            //     calories: 159,
            //     fat: 6.0,
            //     carbs: 24,
            //     protein: 4.0,
            //     iron: '1%',
            //   ],
            //   [
            //     name: 'Ice cream sandwich',
            //     calories: 237,
            //     fat: 9.0,
            //     carbs: 37,
            //     protein: 4.3,
            //     iron: '1%',
            //   ],
            //   [
            //     name: 'Eclair',
            //     calories: 262,
            //     fat: 16.0,
            //     carbs: 23,
            //     protein: 6.0,
            //     iron: '7%',
            //   ],
            //   [
            //     name: 'Cupcake',
            //     calories: 305,
            //     fat: 3.7,
            //     carbs: 67,
            //     protein: 4.3,
            //     iron: '8%',
            //   ],
            //   [
            //     name: 'Gingerbread',
            //     calories: 356,
            //     fat: 16.0,
            //     carbs: 49,
            //     protein: 3.9,
            //     iron: '16%',
            //   ],
            //   [
            //     name: 'Jelly bean',
            //     calories: 375,
            //     fat: 0.0,
            //     carbs: 94,
            //     protein: 0.0,
            //     iron: '0%',
            //   ],
            //   [
            //     name: 'Lollipop',
            //     calories: 392,
            //     fat: 0.2,
            //     carbs: 98,
            //     protein: 0,
            //     iron: '2%',
            //   ],
            //   [
            //     name: 'Honeycomb',
            //     calories: 408,
            //     fat: 3.2,
            //     carbs: 87,
            //     protein: 6.5,
            //     iron: '45%',
            //   ],
            //   [
            //     name: 'Donut',
            //     calories: 452,
            //     fat: 25.0,
            //     carbs: 51,
            //     protein: 4.9,
            //     iron: '22%',
            //   ],
            //   [
            //     name: 'KitKat',
            //     calories: 518,
            //     fat: 26.0,
            //     carbs: 65,
            //     protein: 7,
            //     iron: '6%',
            //   ],
            // ],
        ];

        return $data;
    }
}
