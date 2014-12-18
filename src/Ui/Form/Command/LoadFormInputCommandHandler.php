<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class LoadFormInputCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class LoadFormInputCommandHandler
{

    /**
     * Handle the command.
     *
     * @param LoadFormInputCommand $command
     */
    public function handle(LoadFormInputCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $stream  = $form->getStream();

        if (app('request')->isMethod('post') && $stream instanceof StreamInterface) {
            // Set the input
        }
    }
}
