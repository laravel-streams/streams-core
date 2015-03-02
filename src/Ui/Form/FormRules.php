<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class FormRules
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormRules
{

    /**
     * Compile rules from form fields.
     *
     * @param Form $form
     * @return array
     */
    public function compile(Form $form)
    {
        $rules = [];

        $entry  = $form->getEntry();
        $stream = $form->getStream();

        foreach ($form->getFields() as $field) {

            if ($field->isDisabled()) {
                continue;
            }

            $fieldRules = $field->getRules();

            if ($entry instanceof EntryInterface) {
                $fieldRules = $fieldRules + $entry->getFieldRules($field->getField());
            }

            if (!$stream instanceof StreamInterface) {

                $rules[$field->getInputName()] = implode('|', $fieldRules);

                continue;
            }

            if ($assignment = $stream->getAssignment($field->getField())) {

                if ($assignment->isRequired()) {
                    $fieldRules[] = 'required';
                }
                /*if ($assignment->isUnique()) {

                    $unique = 'unique:' . $stream->getEntryTableName() . ',' . $field->getColumnName();

                    if ($entry && $id = $entry->getId()) {
                        $unique .= ',' . $id;
                    }

                    $fieldRules[] = $unique;
                }*/
            }

            $rules[$field->getInputName()] = implode('|', $fieldRules);
        }

        return array_filter($rules);
    }
}
