<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;

/**
 * Class BuildFormSectionColumnsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionColumnsCommandHandler
{

    use CommandableTrait;

    /**
     * The form utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUtility
     */
    protected $utility;

    /**
     *Create a new BuildFormSectionColumnsCommandHandler instance.
     *
     * @param FormUtility $utility
     */
    function __construct(FormUtility $utility)
    {
        $utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildFormSectionColumnsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionColumnsCommand $command)
    {
        $form = $command->getForm();

        $entry   = $form->getEntry();
        $utility = $form->getUtility();

        $columns = [];

        foreach ($command->getColumns() as $column) {

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $column = $utility->evaluate($column, [$form, $entry], $entry);

            $command = new BuildFormSectionFieldsCommand($form, $column['fields']);

            $fields = $this->execute($command);

            $columns[] = compact('fields');
        }

        return $columns;
    }
}
 