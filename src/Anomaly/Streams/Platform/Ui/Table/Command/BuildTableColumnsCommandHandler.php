<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Support\Presenter;
use Anomaly\Streams\Platform\Ui\Table\TableUtility;
use Anomaly\Streams\Platform\Assignment\AssignmentService;

/**
 * Class BuildTableColumnsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableColumnsCommandHandler
{

    /**
     * The assignment service object.
     *
     * @var \Anomaly\Streams\Platform\Assignment\AssignmentService
     */
    protected $service;

    /**
     * The table utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUtility
     */
    protected $utility;

    /**
     * Create a new BuildTableColumnsCommandHandler instance.
     *
     * @param AssignmentService $service
     * @param TableUtility      $utility
     */
    function __construct(AssignmentService $service, TableUtility $utility)
    {
        $this->service = $service;
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return array
     */
    public function handle($command)
    {
        $ui    = $command->getUi();
        $entry = $command->getEntry();

        $columns = [];

        foreach ($ui->getColumns() as $column) {

            // Standardize input.
            $column = $this->standardize($column);

            // Evaluate the column.
            // All closures are gone now.
            $column = $this->utility->evaluate($column, [$ui, $entry], $entry);

            // Build out our required data.
            $value = $this->getValue($column, $entry);

            $columns[] = compact('value');

        }

        return $columns;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $column
     * @return array
     */
    protected function standardize($column)
    {
        /**
         * If the column is a string it means
         * they just passed in the field slug.
         */
        if (is_string($column)) {

            $column = ['field' => $column];

        }

        return $column;
    }

    /**
     * Get the value.
     *
     * @param $column
     * @param $entry
     * @return string
     */
    protected function getValue($column, $entry)
    {
        $value = null;

        /**
         * Chances are if the value is set
         * then the user is making their own.
         */
        if (isset($column['value'])) {

            $value = $column['value'];

        }

        /**
         * If the value is NOT set then chances are
         * the user is using dot notation or
         * getting the value from the entry
         * by field slug.
         */
        if (isset($column['field'])) {

            $value = $column['field'];

        }

        /**
         * Try getting the value from the entry.
         * This returns the value passed if N/A.
         */
        $value = $this->getValueFromEntry($value, $entry);

        return (string)$value;
    }

    /**
     * Try getting the value from the entry object.
     * If nothing is found then pass back the value
     * as it was passed in originally.
     *
     * @param $value
     * @param $entry
     * @return mixed
     */
    protected function getValueFromEntry($value, $entry)
    {
        $parts = explode('.', $value);

        /**
         * If the field is or starts with a valid property
         * this will return the value or the FieldType
         * presenter for said field.
         */
        if ($value = $entry->getValueFromField($parts[0])) {

            $value = $this->parseValue($value, $parts);

        }

        return $value;
    }

    /**
     * Parse the value into any decorating standards.
     *
     * @param $value
     * @param $parts
     * @return mixed
     */
    protected function parseValue($value, $parts)
    {
        /**
         * If the value is dot notated then try and parse
         * the values inward on the entry.
         */
        if (count($parts) > 1 and $value) {

            $value = $this->parseDotNotation($value, $parts);

        }

        return $value;
    }

    /**
     * Recur into a value object to extract the dot
     * notated value that has been exploded into parts.
     *
     * @param $value
     * @param $parts
     * @return mixed
     */
    protected function parseDotNotation($value, $parts)
    {
        foreach (array_slice($parts, 1) as $part) {

            try {

                $value = $value->$part;

            } catch (\Exception $e) {

                // Shh..
            }

        }

        return $value;
    }

}
 