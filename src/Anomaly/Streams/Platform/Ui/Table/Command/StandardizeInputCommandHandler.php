<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Button\ButtonReader;
use Anomaly\Streams\Platform\Ui\Table\Action\ActionReader;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnReader;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Exception\IncompatibleModelException;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

class StandardizeInputCommandHandler
{

    use CommanderTrait;

    public function handle(StandardizeInputCommand $command)
    {
        $builder = $command->getBuilder();

        $this->standardizeModelInput($builder);

        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\View\Command\StandardizeViewInputCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Filter\Command\StandardizeFilterInputCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Column\Command\StandardizeColumnInputCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Header\Command\StandardizeHeaderInputCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Button\Command\StandardizeButtonInputCommand',
            compact('builder')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Action\Command\StandardizeActionInputCommand',
            compact('builder')
        );
    }

    protected function standardizeModelInput(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $class = $builder->getModel();

        if (!class_exists($class)) {

            return;
        }

        $model = app($class);

        /**
         * If the model can extract a Stream then
         * set it on the table at this time so we
         * can use it later if we need.
         */
        if ($model instanceof EntryInterface) {

            $table->setStream($model->getStream());
        }

        if (!$model instanceof TableModelInterface) {

            throw new IncompatibleModelException("[$class] must implement Anomaly\\Streams\\Platform\\Ui\\Table\\Contract\\TableModelInterface");
        }

        $builder->setModel($model);
    }
}
 