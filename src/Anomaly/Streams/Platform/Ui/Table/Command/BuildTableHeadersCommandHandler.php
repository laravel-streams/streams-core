<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableUi;

class BuildTableHeadersCommandHandler
{
    public function handle(BuildTableHeadersCommand $command)
    {
        $ui = $command->getUi();

        $columns = [];

        foreach ($ui->getColumns() as $column) {

            if (is_string($column)) {

                $column = ['field' => $column];

            }

            $title = $this->makeTitle($column, $ui);

            $columns[] = compact('title');

        }

        return $columns;
    }

    protected function makeTitle($column, TableUi $ui)
    {
        $title = trans(evaluate_key($column, 'title', null, [$ui]));

        if (!$title and $model = $ui->getModel() and $model instanceof EntryInterface) {

            $title = $this->makeTitleFromField($column, $model);

        }

        if (!$title) {

            $this->makeTitleFromColumn($column, $ui);

        }

        return $title;
    }

    protected function makeTitleFromField($column, $model)
    {
        if ($assignment = $model->getStream()->assignments->findByFieldSlug($column['field'])) {

            return $assignment->field->name;

        }

        return null;
    }

    protected function makeTitleFromColumn($column, $ui)
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
 