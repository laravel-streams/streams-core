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

        foreach ($table->getColumns() as $column) {

            $column = $this->standardize($column);

            // Evaluate everything in the array.
            // All closures are gone now.
            $column = $this->utility->evaluate($column, [$table]);

            // Build out our required data.
            $heading = $this->getHeading($column, $table);

            $columns[] = compact('heading');
        }

        return $columns;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $column
     */
    protected function standardize($column)
    {
        /**
         * If the column is a string
         * then assume it's the field.
         */
        if (is_string($column)) {

            $column = ['field' => $column];
        }

        return $column;
    }

    /**
     * Get the heading.
     *
     * @param array   $column
     * @param Table $table
     * @return null|string
     */
    protected function getHeading(array $column, Table $table)
    {
        $heading = trans(evaluate_key($column, 'heading', null, [$table]));

        if (!$heading and $entry = $table->getModel() and $entry instanceof EntryInterface) {

            $heading = $this->getHeadingFromField($column, $entry);
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
     * @param EntryInterface $entry
     * @return null
     */
    protected function getHeadingFromField(array $column, EntryInterface $entry)
    {
        $parts = explode('.', $column['field']);

        if ($name = $entry->getFieldName($parts[0])) {

            return trans($name);
        }

        return null;
    }

    /**
     * Make our best guess at the heading.
     *
     * @param array   $column
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
}
 