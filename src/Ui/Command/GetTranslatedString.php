<?php namespace Anomaly\Streams\Platform\Ui\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Translation\Translator;

/**
 * Class GetTranslatedString
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Command
 */
class GetTranslatedString implements SelfHandling
{

    /**
     * The translation key.
     *
     * @var string
     */
    protected $key;

    /**
     * The locale key.
     *
     * @var string
     */
    protected $locale;

    /**
     * The translation parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Create a new GetTranslatedString instance.
     *
     * @param string $key
     * @param array  $parameters
     * @param string $locale
     */
    public function __construct($key, array $parameters, $locale)
    {
        $this->key        = $key;
        $this->locale     = $locale;
        $this->parameters = $parameters;
    }

    /**
     * Handle the command.
     *
     * @param Translator $translator
     * @return string
     */
    public function handle()
    {
        if (!$this->key) {
            return $this->key;
        }

        if (is_array($string = trans($this->key, $this->parameters, $this->locale))) {
            return $this->key;
        }

        return $string;
    }
}
