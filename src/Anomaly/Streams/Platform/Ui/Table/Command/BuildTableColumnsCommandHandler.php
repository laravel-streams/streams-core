<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentService;
use Anomaly\Streams\Platform\Entry\EntryInterface;

class BuildTableColumnsCommandHandler
{
    protected $service;

    function __construct(AssignmentService $service)
    {
        $this->service = $service;
    }


    public function handle(BuildTableColumnsCommand $command)
    {
        $ui    = $command->getUi();
        $entry = $command->getEntry();

        $columns = [];

        foreach ($ui->getColumns() as $column) {

            if (is_string($column)) {

                $column = ['field' => $column];

            }

            $value = $this->makeValue($column, $ui, $entry);

            $columns[] = compact('value');

        }

        return $columns;
    }

    protected function makeValue($column, $ui, $entry)
    {
        $value = evaluate_key($column, 'value', null, [$ui, $entry]);

        // TODO: Presenters are fucking annoying outside of views.. Fix this.
        if ($entry->getResource() instanceof EntryInterface) {

            $value = $this->makeValueFromEntry($column, $ui, $entry->getResource(), $value);

        }

        return $value;
    }

    protected function makeValueFromEntry($column, $ui, $entry, $value)
    {
        if (!$value and $assignment = $entry->getStream()->assignments->findByFieldSlug($column['field'])) {

            return $this->service->buildFieldType($assignment, $entry)->getValue();

        } else {

            return merge($value, $entry->toArray());

        }
    }
}
 