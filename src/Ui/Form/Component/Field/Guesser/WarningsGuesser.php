<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class WarningsGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class WarningsGuesser
{

    /**
     * Guess the field warnings.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $stream = $builder->getFormStream();

        foreach ($fields as &$field) {

            /*
             * If the warning are already set then use it.
             */
            if (isset($field['warning'])) {
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
             * Try stream specific warning.
             */
            $warning = $stream->location('field.' . $field['field'] . '.warning.' . $stream->slug);

            if (!isset($field['warning']) && trans()->has($warning)) {
                $field['warning'] = $warning;
            }

            /**
             * Try the warning.
             */
            $warning = $stream->location('field.' . $field['field'] . '.warning');

            if (!isset($field['warning']) && trans()->has($warning)) {
                $field['warning'] = $warning;
            }
        }

        $builder->setFields($fields);
    }
}
