<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class HandleFormValidationCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormValidationCommandHandler
{
    /**
     * Handle the command.
     *
     * @param HandleFormValidationCommand $command
     */
    public function handle(HandleFormValidationCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $input = $form->pullInput(config('app.locale'), []) + $form->pullInput('include', []);

        $validator = app('validator')->make($input, $form->getRules());

        if ($validator->fails()) {
            app('session')->flash('error', $validator->messages()->all());

            $form->setResponse(false);
        }
    }
}
