<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableUtility;

/**
 * Class BuildTableHeadersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableHeadersCommandHandler
{

    /**
     * The table utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUtility
     */
    protected $utility;

    /**
     * Create a new BuildTableHeadersCommandHandler instance.
     *
     * @param TableUtility $utility
     */
    function __construct(TableUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildTableHeadersCommand $command
     * @return array
     */
    public function handle(BuildTableHeadersCommand $command)
    {
        $table = $command->getTable();

        $columns = [];

        foreach ($table->getColumns() as $slug => $column) {

            $column = $this->standardize($slug, $column);

            // Evaluate everything in the array.
            // All closures are gone now.
            $column = $this->utility->evaluate($column, [$table]);

            // Build out our required data.
            $heading = $this->getHeading($column, $table);
            $sorting = $this->getSorting($column, $table);
            $url     = $this->getUrl($column, $table, $sorting);

            $columns[] = compact('heading', 'sorting', 'url');
        }

        return $columns;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $slug
     * @param $column
     * @return array
     */
    protected function standardize($slug, $column)
    {

        /**
         * If the slug is numerical and the column
         * is a string then use view for both.
         */
        if (is_numeric($slug) and is_string($column)) {

            return [
                'field' => $column,
                'slug'  => $column,
            ];
        }

        /**
         * If the slug is a string and the view
         * is too then use the slug as slug and
         * the view as the type.
         */
        if (is_string($column)) {

            return [
                'field' => $column,
                'slug'  => $slug,
            ];
        }

        /**
         * If the slug is not explicitly set
         * then default it to the slug inferred.
         */
        if (is_array($column) and !isset($column['slug'])) {

            $column['slug'] = $slug;
        }

        return $column;
    }

    /**
     * Get the heading.
     *
     * @param array $column
     * @param Table $table
     * @return null|string
     */
    protected function getHeading(array $column, Table $table)
    {
        $heading = trans(evaluate_key($column, 'heading', null, [$table]));

        if (!$heading and $model = $table->getModel() and $model instanceof EntryInterface) {

            $heading = $this->getHeadingFromField($column, $model);
        }

        if (!$heading) {

            $this->guessHeading($column, $table);
        }

        return $heading;
    }

    /**
     * Get the heading from a field.
     *
     * @param array          $column
     * @param EntryInterface $model
     * @return null
     */
    protected function getHeadingFromField(array $column, EntryInterface $model)
    {
        $parts = explode('.', $column['field']);

        if ($name = $model->getFieldName($parts[0])) {

            return trans($name);
        }

        return null;
    }

    /**
     * Make our best guess at the heading.
     *
     * @param array $column
     * @param Table $table
     * @return mixed|null|string
     */
    protected function guessHeading(array $column, Table $table)
    {
        $heading = evaluate_key($column, 'heading', evaluate_key($column, 'field', null), [$table]);

        $translated = trans($heading);

        if ($translated == $heading) {

            $heading = humanize($heading);
        }

        if ($translated != $heading) {

            $heading = $translated;
        }

        return $heading;
    }

    /**
     * Get the sorting status if any of the column.
     *
     * @param array $column
     * @param Table $table
     * @return null
     */
    protected function getSorting(array $column, Table $table)
    {
        $parts = explode('.', $column['slug']);

        if ($model = $table->getModel() and $model instanceof EntryInterface) {

            if ($type = $model->fieldType($parts[0])) {

                $key = $table->getPrefix() . 'order_by';

                if (app('request')->has($key)) {

                    list($column, $direction) = explode('|', app('request')->get($key));

                    if ($column == $type->getColumnName()) {

                        return $direction;
                    }
                }
            }
        }

        return null;
    }

    protected function getUrl(array $column, Table $table, $sorting)
    {
        $parts = explode('.', $column['slug']);

        $orderBy   = null;
        $direction = null;

        $key   = $table->getPrefix() . 'order_by';
        $value = app('request')->get($key);

        if ($model = $table->getModel() and $model instanceof EntryInterface) {

            if ($type = $model->fieldType($parts[0])) {

                $orderBy = $type->getColumnName();
            }
        }

        if (!$orderBy) {

            $orderBy = $column['slug'];
        }

        $direction = ends_with($value, 'asc') ? 'desc' : 'asc';

        $query = app('request')->all();

        $query[$key] = $orderBy . '|' . $direction;

        $query = http_build_query($query);

        if (is_numeric($orderBy)) {

            return null;
        }

        return app('request')->url('/') . '?' . $query;
    }
}
 