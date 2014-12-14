<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Exception\IncompatibleModelException;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class StandardizeInputCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class StandardizeInputCommandHandler
{
    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param StandardizeInputCommand $command
     */
    public function handle(StandardizeInputCommand $command)
    {
        $builder = $command->getBuilder();

        $this->standardizeModelInput($builder);

        $args = compact('builder');

        $this->execute('Anomaly\Streams\Platform\Ui\Table\View\Command\StandardizeViewInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\StandardizeFilterInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Column\Command\StandardizeColumnInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Header\Command\StandardizeHeaderInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Button\Command\StandardizeButtonInputCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Action\Command\StandardizeActionInputCommand', $args);
    }

    /**
     * Standardize the model input.
     *
     * @param TableBuilder $builder
     * @throws \Anomaly\Streams\Platform\Ui\Table\Exception\IncompatibleModelException
     */
    protected function standardizeModelInput(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $model = $builder->getModel();

        if (!$model) {
            return;
        }

        if (is_string($model)) {
            $model = app($model);
        }

        /**
         * If the model can extract a Stream then
         * set it on the table at this time so we
         * can use it later if we need.
         */
        if ($model instanceof EntryInterface) {
            $table->setStream($model->getStream());
        }

        if (!$model instanceof TableModelInterface) {
            throw new IncompatibleModelException("[get_class($model)] must implement Anomaly\\Streams\\Platform\\Ui\\Table\\Contract\\TableModelInterface");
        }

        $builder->setModel($model);
    }
}
