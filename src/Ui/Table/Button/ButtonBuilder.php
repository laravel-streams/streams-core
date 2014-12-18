<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Button
 */
class ButtonBuilder extends \Anomaly\Streams\Platform\Ui\Button\ButtonBuilder
{

    /**
     * Build the buttons and load it onto the table.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $buttons = $table->getButtons();

        foreach ($builder->getButtons() as $key => $parameters) {

            $parameters = $this->interpreter->standardize($key, $parameters);
            $parameters = $this->evaluator->process($parameters, $builder);

            $button = $this->factory->make($parameters);

            $buttons->push($button);
        }
    }
}
