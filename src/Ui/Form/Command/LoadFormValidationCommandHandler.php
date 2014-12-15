<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class LoadFormValidationCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class LoadFormValidationCommandHandler
{

    /**
     * Handle the command.
     *
     * @param LoadFormValidationCommand $command
     */
    public function handle(LoadFormValidationCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $stream  = $form->getStream();

        if ($stream instanceof StreamInterface) {
            foreach ($stream->getAssignments() as $assignment) {
                if (!in_array($assignment->getFieldSlug(), $form->getSkips())) {
                    $type = $assignment->getFieldType();

                    $rules = $type->getRules();

                    if ($assignment->isRequired()) {
                        $rules[] = 'required';
                    }

                    if ($assignment->isUnique()) {
                        $rule = 'unique:' . $stream->getEntryTableName() . ',' . $type->getColumnName();

                        if ($entry = $builder->getEntry()) {
                            $rule .= ',' . $entry;
                        }

                        $rules[] = $rule;
                    }

                    $form->putRules($assignment->getFieldSlug(), $rules);
                }
            }
        }
    }
}
