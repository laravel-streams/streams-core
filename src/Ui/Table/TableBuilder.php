<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Row;
use Anomaly\Streams\Platform\Ui\Table\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewCollection;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

/**
 * Class TableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableBuilder
{

    use HasAttributes;
    use FiresCallbacks;

    /**
     * The table attributes.
     *
     * @var array
     */
    protected $attributes = [

        'async' => false,

        'stream' => null,
        'entries' => null,
        'repository' => null,

        'views' => [],
        'assets' => [],
        'filters' => [],
        'columns' => [],
        'buttons' => [],
        'actions' => [],
        'options' => [],

        'table' => Table::class,
    ];

    /**
     * Build the table.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->built === true) {
            return $this;
        }

        $this->fire('ready', ['builder' => $this]);

        (new BuildWorkflow)->process(['builder' => $this]);

        $this->fire('built', ['builder' => $this]);

        $this->built = true;

        return $this;
    }

    /**
     * Render the table.
     *
     * @return View
     */
    public function render()
    {
        $this->build();

        return $this->table->render();
    }

    /**
     * Return the table response.
     * 
     * @return Response
     */
    public function response()
    {
        return Response::view('streams::default', ['content' => $this->render()]);
    }

    /**
     * Get the ajax flag.
     *
     * @return bool
     */
    public function isAjax()
    {
        return $this->ajax;
    }

    /**
     * Set the ajax flag.
     *
     * @param $ajax
     * @return $this
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;

        return $this;
    }

    /**
     * Get the table object.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the table model.
     *
     * @param  string $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the table model.
     *
     * @return null|string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get the entries.
     *
     * @return null|string
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set the entries.
     *
     * @param $entries
     * @return $this
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Get the repository.
     *
     * @return RepositoryInterface|null
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Set the repository.
     *
     * @param  RepositoryInterface $repository
     * @return $this
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Add a view.
     *
     * @param $slug
     * @param $view
     * @return $this
     */
    public function addView($slug, $view)
    {
        $this->views[$slug] = $view;

        return $this;
    }

    /**
     * Set the views configuration.
     *
     * @param $views
     * @return $this
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get the views configuration.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set the filters configuration.
     *
     * @param $filters
     * @return $this
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get the filters configuration.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Add a column configuration.
     *
     * @param $column
     * @return $this
     */
    public function addColumn($column)
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * Set the columns configuration.
     *
     * @param $columns
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get the columns configuration.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Add a button.
     *
     * @param $slug
     * @param $button
     * @return $this
     */
    public function addButton($slug, $button)
    {
        $this->buttons[$slug] = $button;

        return $this;
    }

    /**
     * Add more buttons.
     *
     * @param       $slug
     * @param array $buttons
     * @return $this
     */
    public function addButtons(array $buttons)
    {
        $this->buttons = array_merge($this->buttons, $buttons);

        return $this;
    }

    /**
     * Set the buttons configuration.
     *
     * @param $buttons
     * @return $this
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * Get the buttons configuration.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the actions configuration.
     *
     * @param $actions
     * @return $this
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get the actions configuration.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * The the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param  array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

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
        return array_get($this->options, $key, $default);
    }

    /**
     * Set an option value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        array_set($this->options, $key, $value);

        return $this;
    }

    /**
     * Return if the form has an option.
     *
     * @param $key
     * @return bool
     */
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * Get the assets.
     *
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Set the assets.
     *
     * @param $assets
     * @return $this
     */
    public function setAssets($assets)
    {
        $this->assets = $assets;

        return $this;
    }

    /**
     * Add an asset.
     *
     * @param $collection
     * @param $asset
     * @return $this
     */
    public function addAsset($collection, $asset)
    {
        if (!isset($this->assets[$collection])) {
            $this->assets[$collection] = [];
        }

        $this->assets[$collection][] = $asset;

        return $this;
    }

    /**
     * Get the table's stream.
     *
     * @return \Anomaly\Streams\Platform\Stream\Contract\StreamInterface|null
     */
    public function getTableStream()
    {
        return $this->table->getStream();
    }

    /**
     * Get the table model.
     *
     * @return Model|null
     */
    public function getTableModel()
    {
        return $this->table->getModel();
    }

    /**
     * Get a table option value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function getTableOption($key, $default = null)
    {
        return $this->table->options->get($key, $default);
    }

    /**
     * Set a table option value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setTableOption($key, $value)
    {
        $this->table->setOption($key, $value);

        return $this;
    }

    /**
     * Get the table options.
     *
     * @return Collection
     */
    public function getTableOptions()
    {
        return $this->table->options;
    }

    /**
     * Set the table entries.
     *
     * @param  Collection $entries
     * @return $this
     */
    public function setTableEntries(Collection $entries)
    {
        $this->table->setEntries($entries);

        return $this;
    }

    /**
     * Get the table entries.
     *
     * @return Collection
     */
    public function getTableEntries()
    {
        return $this->table->entries;
    }

    /**
     * Get the table actions.
     *
     * @return Component\Action\ActionCollection
     */
    public function getTableActions()
    {
        return $this->table->getActions();
    }

    /**
     * Get the table filters.
     *
     * @return Component\Filter\FilterCollection
     */
    public function getTableFilters()
    {
        return $this->table->filters;
    }

    /**
     * Get the active table filters.
     *
     * @return Component\Filter\FilterCollection
     */
    public function getActiveTableFilters()
    {
        return $this->table
            ->filters
            ->active();
    }

    /**
     * Get the table filter.
     *
     * @param $key
     * @return FilterInterface
     */
    public function getTableFilter($key)
    {
        return $this->table->getFilter($key);
    }

    /**
     * Get a table filter value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function getTableFilterValue($key, $default = null)
    {
        if ($filter = $this->table->getFilter($key)) {
            return $filter->value;
        }

        return $default;
    }

    /**
     * Get the table views.
     *
     * @return Component\View\ViewCollection
     */
    public function getTableViews()
    {
        return $this->table->getViews();
    }

    /**
     * Set the table views.
     *
     * @param  ViewCollection $views
     * @return $this
     */
    public function setTableViews(ViewCollection $views)
    {
        $this->table->setViews($views);

        return $this;
    }

    /**
     * Return whether the table has an active view.
     *
     * @return bool
     */
    public function hasActiveView()
    {
        return !is_null($this->table->getViews()->active());
    }

    /**
     * Return whether the table view is active.
     *
     * @param $slug
     * @return bool
     */
    public function isActiveView($slug)
    {
        if ($active = $this->table->getViews()->active()) {
            return $active->slug === $slug;
        }

        return false;
    }

    /**
     * Get the active table view.
     *
     * @return null|View
     */
    public function getActiveTableView()
    {
        if (!$views = $this->getTableViews()) {
            return null;
        }

        if (!$active = $views->active()) {
            return null;
        }

        return $active;
    }

    /**
     * Add a row to the table.
     *
     * @param  Row $row
     * @return $this
     */
    public function addTableRow(Row $row)
    {
        $this->table->rows->push($row);

        return $this;
    }

    /**
     * Add data to the table.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function addTableData($key, $value)
    {
        $this->table->addData($key, $value);

        return $this;
    }

    /**
     * Get the table response.
     *
     * @return null|Response
     */
    public function getTableResponse()
    {
        return $this->table->getResponse();
    }

    /**
     * Get the table content.
     *
     * @return null|string
     */
    public function getTableContent()
    {
        return $this->table->getContent();
    }

    /**
     * Get a request value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function getRequestValue($key, $default = null)
    {
        return array_get($_REQUEST, $this->getOption('prefix') . $key, $default);
    }
}
