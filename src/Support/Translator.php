<?php

namespace Anomaly\Streams\Platform\Support;

/**
 * Class Translator.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Translator
{
    /**
     * The laravel translator.
     *
     * @var \Illuminate\Translation\Translator
     */
    protected $translator;

    /**
     * Create a new translator instance.
     *
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(\Illuminate\Translation\Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Translate a target array.
     *
     * @param array $target
     * @return array
     */
    public function translate(array $target)
    {
        foreach ($target as &$value) {
            if (is_string($value) && $this->translator->has($value)) {
                $value = $this->translator->trans($value);
            } elseif (is_array($value)) {
                $value = $this->translate($value);
            }
        }

        return $target;
    }
}
