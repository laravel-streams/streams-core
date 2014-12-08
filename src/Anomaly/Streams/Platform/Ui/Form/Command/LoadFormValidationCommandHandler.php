<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

class LoadFormValidationCommandHandler
{

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
 