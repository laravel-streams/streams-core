<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Support\Presenter;
use Anomaly\Streams\Platform\Entry\EntryInterface;
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
     * Create a new BuildTableColumnsCommandHandler instance.
     *
     * @param AssignmentService $service
     */
    function __construct(AssignmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the command.
     *
     * @param BuildTableColumnsCommand $command
     * @return array
     */
    public function handle(BuildTableColumnsCommand $command)
    {
        $ui    = $command->getUi();
        $entry = $command->getEntry();

        $columns = [];

        foreach ($ui->getColumns() as $column) {

            /**
             * If the column is a string it means
             * they just passed in the field slug.
             */
            if (is_string($column)) {

                $column = ['field' => $column];

            }

            // Evaluate the column.
            // All closures are gone now.
            $column = $this->evaluate($column, $ui, $entry);

            // Build out our required data.
            $value = $this->getValue($column, $entry);

            $columns[] = compact('value');

        }

        return $columns;
    }

    /**
     * Evaluate each array item for closures.
     * Merge in entry data at this point too.
     *
     * @param $column
     * @param $ui
     * @param $entry
     * @return mixed|null
     */
    protected function evaluate($column, $ui, $entry)
    {
        $column = evaluate($column, [$ui, $entry]);

        /**
         * In addition to evaluating we need
         * to merge in entry data as best we can.
         */
        foreach ($column as &$value) {

            if (is_string($value) and str_contains($value, '{')) {

                if ($entry instanceof EntryInterface) {

                    $value = merge($value, $entry->toArray());

                }

            }

        }

        return $column;
    }

    /**
     * Get the value.
     *
     * @param                $column
     * @param EntryInterface $entry
     * @return string
     */
    protected function getValue($column, EntryInterface $entry)
    {
        if (isset($column['value'])) {

            /**
             * Chances are if the value is set
             * then the user is making their own.
             */
            $value = $column['value'];

        } else {

            /**
             * If the value is NOT set then chances are
             * the user is using dot notation or
             * getting the value from the entry
             * by field slug.
             */
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
     * @param                $value
     * @param EntryInterface $entry
     * @return mixed
     */
    protected function getValueFromEntry($value, EntryInterface $entry)
    {
        $parts = explode('.', $value);

        /**
         * If the field is or starts with a valid property
         * this will return the value or the FieldType
         * presenter for said field.
         */
        if ($fieldValue = $entry->getValueFromField($parts[0])) {

            $value = $fieldValue;

            /**
             * If the value was a field slug and dot notated then
             * try and parse the values inward on the entry / presenter.
             */
            if (count($parts) > 1 and $value instanceof Presenter) {

                $value = $this->parseDotNotation($value, $parts);

            }

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
 