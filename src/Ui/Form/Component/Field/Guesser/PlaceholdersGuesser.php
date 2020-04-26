<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class PlaceholdersGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PlaceholdersGuesser
{

    /**
     * Guess the field placeholders.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $stream = $builder->getFormStream();

        foreach ($fields as &$field) {

            /*
             * If the placeholder are already set then use it.
             */
            if (isset($field['placeholder'])) {
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
             * Try stream specific placeholder.
             */
            $placeholder = $stream->location('field.' . $field['field'] . '.placeholder.' . $stream->slug);

            if (!isset($field['placeholder']) && trans()->has($placeholder)) {
                $field['placeholder'] = $placeholder;
            }

            /**
             * Try the general field placeholder.
             */
            $placeholder = $stream->location('field.' . $field['field'] . '.placeholder');

            if (!isset($field['placeholder']) && trans()->has($placeholder)) {
                $field['placeholder'] = $placeholder;
            }
        }

        $builder->setFields($fields);
    }
}
