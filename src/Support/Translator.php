<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Translator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * @param  array $target
     * @return array
     */
    public function translate($target)
    {
        if (is_string($target)) {
            return $this->translator->trans($target);
        }

        if (is_array($target)) {
            foreach ($target as &$value) {
                if (is_string($value) && $this->translator->has($value)) {
                    $value = $this->translator->trans($value);
                } elseif (is_array($value)) {
                    $value = $this->translate($value);
                }
            }
        }

        return $target;
    }
}
