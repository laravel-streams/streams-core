<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Support\Traits\Properties;
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

    use Properties;
    use FiresCallbacks;

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes([
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
        ]);

        $this->buildProperties();

        $this->fill($attributes);
    }

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
