<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Http\Request;

/**
 * Class SetDefaultOptions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetDefaultOptions
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultOptions instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param ModuleCollection $modules
     * @param ThemeCollection $themes
     * @param Request $request
     */
    public function handle(ModuleCollection $modules, ThemeCollection $themes, Request $request)
    {
        $theme = $themes->current();

        $table = $this->builder->getTable();

        /*
         * Set the default sortable option.
         */
        if ($table->getOption('sortable') === null) {
            $stream = $table->getStream();

            if ($stream && $stream->isSortable()) {
                $table->setOption('sortable', true);
            }
        }

        /*
         * Default the table view based on the request.
         */
        if (!$this->builder->getTableOption('table_view') && $this->builder->isAjax()) {
            $this->builder->setTableOption('table_view', 'streams::table/ajax');
        }

        if (!$this->builder->getTableOption('table_view') && $theme && $theme->isAdmin()) {
            $this->builder->setTableOption('table_view', 'streams::table/table');
        }

        if (!$this->builder->getTableOption('table_view') && $theme && !$theme->isAdmin()) {
            $this->builder->setTableOption('table_view', 'streams::table/standard');
        }

        if (!$this->builder->getTableOption('table_view')) {
            $this->builder->setTableOption('table_view', 'streams::table/table');
        }

        /*
         * Sortable tables have no pages.
         */
        if ($table->getOption('sortable') === true) {
            $table->setOption('limit', $table->getOption('limit', 99999));
        }

        /*
         * Set the default breadcrumb.
         */
        if ($table->getOption('breadcrumb') === null && $title = $table->getOption('title')) {
            $table->setOption('breadcrumb', $title);
        }

        /*
         * If the table ordering is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect.
         */
        if ($orderBy = $this->builder->getRequestValue('order_by')) {
            if ($this->orderable($orderBy)) {
                $table->setOption(
                    'order_by',
                    [$orderBy => $this->direction($this->builder->getRequestValue('sort', 'asc'))]
                );
            }
        }

        /*
         * If the table limit is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect. Otherwise default.
         */
        if ($table->getOption('limit') === null) {
            $table->setOption(
                'limit',
                ($limit = $this->builder->getRequestValue('limit')) === null
                    ? config('streams::system.per_page', 15)
                    : $this->builder->limit($limit)
            );
        }

        /*
         * If the permission is not set then
         * try and automate it.
         */
        if (
            $table->getOption('permission') === null &&
            $request->segment(1) == 'admin' &&
            ($module = $modules->active()) &&
            ($stream = $this->builder->getTableStream())
        ) {
            $table->setOption('permission', $module->getNamespace($stream->getSlug() . '.read'));
        }
    }

    /**
     * Return whether the table may be ordered by the column.
     *
     * @param  mixed $column
     * @return bool
     */
    protected function orderable($column)
    {
        if (!is_string($column)) {
            return false;
        }

        /*
         * A builder may declare a sort column the table does not
         * have - joined or aliased - and the header guesser marks
         * it sortable on that declaration alone, so honour it.
         */
        foreach ((array)$this->builder->getColumns() as $definition) {
            if (is_array($definition) && array_get($definition, 'sort_column') === $column) {
                return true;
            }
        }

        if (!$model = $this->builder->getTableModel()) {
            return false;
        }

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());

        if (in_array($column, $columns)) {
            return true;
        }

        /*
         * A field type may order by a column named differently
         * to its slug, so resolve that before giving up. Anything
         * not on the table itself - a translatable field, say -
         * cannot be ordered by and is left to the default.
         */
        if (($stream = $this->builder->getTableStream()) && $type = $stream->getFieldType($column)) {
            return in_array($type->getColumnName(), $columns);
        }

        return false;
    }

    /**
     * Return a sort direction.
     *
     * @param  mixed $direction
     * @return string
     */
    protected function direction($direction)
    {
        return is_string($direction) && strtolower($direction) === 'desc' ? 'desc' : 'asc';
    }
}
