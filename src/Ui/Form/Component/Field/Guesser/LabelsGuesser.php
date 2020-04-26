<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class LabelsGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LabelsGuesser
{

    /**
     * Guess the field labels.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $stream = $builder->getFormStream();

        foreach ($fields as &$field) {

            /*
             * If the label are already set then use it.
             */
            if (isset($field['label'])) {
                continue;
            }

            /*
             * If we don't have a field then we
             * can not really guess anything here.
             */
            if (!isset($field['field'])) {
                continue;
            }

            /*
             * No stream means we can't
             * really do much here.
             */
            if (!$stream instanceof StreamInterface) {
                continue;
            }

            /**
             * Try stream specific label.
             */
            $label = $stream->location('field.' . $field['field'] . '.label.' . $stream->slug);

            if (!isset($field['label']) && trans()->has($label)) {
                $field['label'] = $label;
            }

            /**
             * Start with the label.
             */
            $label = $stream->location('field.' . $field['field'] . '.label');

            if (!isset($field['label']) && trans()->has($label)) {
                $field['label'] = $label;
            }

            /**
             * The name is used as a fallback.
             */
            $label = $stream->location('field.' . $field['field'] . '.name');

            if (!isset($field['label']) && trans()->has($label)) {
                $field['label'] = $label;
            }
        }

        $builder->setFields($fields);
    }
}
