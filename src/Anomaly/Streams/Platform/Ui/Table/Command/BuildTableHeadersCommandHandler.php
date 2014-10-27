<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUi;
use Anomaly\Streams\Platform\Entry\EntryInterface;

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
     * Create a new BuildTableHeadersCommandHandler instance.
     *
     * @param BuildTableHeadersCommand $command
     * @return array
     */
    public function handle(BuildTableHeadersCommand $command)
    {
        $ui = $command->getUi();

        $columns = [];

        foreach ($ui->getColumns() as $column) {

            /**
             * If the column is a string
             * then assume it's the field.
             */
            if (is_string($column)) {

                $column = ['field' => $column];

            }

            // Evaluate everything in the array.
            // All closures are gone now.
            $column = $this->evaluate($column, $ui);

            // Build out our required data.
            $title = $this->getTitle($column, $ui);

            $columns[] = compact('title');

        }

        return $columns;
    }

    /**
     * Evaluate each array item for closures.
     *
     * @param $column
     * @param $ui
     * @return mixed|null
     */
    protected function evaluate($column, $ui)
    {
        return evaluate($column, [$ui]);
    }

    /**
     * Get the title.
     *
     * @param $column
     * @param $ui
     * @return null|string
     */
    protected function getTitle($column, $ui)
    {
        $title = trans(evaluate_key($column, 'title', null, [$ui]));

        if (!$title and $model = $ui->getModel() and $model instanceof EntryInterface) {

            $title = $this->getTitleFromField($column, $model);

        }

        if (!$title) {

            $this->guessTitle($column, $ui);

        }

        return $title;
    }

    /**
     * Get the title from a field.
     *
     * @param $column
     * @param $model
     * @return null
     */
    protected function getTitleFromField($column, $model)
    {
        $parts = explode('.', $column['field']);

        if ($assignment = $model->getStream()->assignments->findByFieldSlug($parts[0])) {

            return $assignment->field->decorate()->name;

        }

        return null;
    }

    /**
     * Make our best guess at the title.
     *
     * @param $column
     * @param $ui
     * @return mixed|null|string
     */
    protected function guessTitle($column, $ui)
    {
        $title = evaluate_key($column, 'title', evaluate_key($column, 'field', null), [$ui]);

        $translated = trans($title);

        if ($translated == $title) {

            $title = humanize($title);

        } else {

            $title = $translated;

        }

        return $title;
    }

}
 