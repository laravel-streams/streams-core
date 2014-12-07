<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Icon\IconReader;

/**
 * Class ButtonReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
 */
class ButtonReader
{

    /**
     * The icon reader.
     *
     * @var
     */
    protected $iconReader;

    /**
     * Create a new ButtonReader instance.
     *
     * @param IconReader $iconReader
     */
    function __construct(IconReader $iconReader)
    {
        $this->iconReader = $iconReader;
    }

    /**
     * Read and convert minimal button input.
     *
     * @param $key
     * @param $value
     */
    public function convert($key, $value)
    {
        /**
         * If the key is numeric and the value
         * is a string then the value is the button.
         */
        if (is_numeric($key) and is_string($value)) {

            $value = [
                'button' => $value,
            ];
        }

        /**
         * If the key is NOT numeric and the value is
         * a string then the value becomes the text and
         * the key is the button.
         */
        if (!is_numeric($key) and is_string($value)) {

            $value = [
                'button' => $key,
                'text'   => $value,
            ];
        }

        /**
         * If the key is a string and the value is an
         * array without a button then the key is the button.
         */
        if (is_array($value) and !isset($value['button']) and !is_numeric($key)) {

            $value['button'] = $key;
        }

        /**
         * If the value is using an icon configuration
         * then make sure it is an array. An icon slug
         * is the most typical case.
         */
        if (is_array($value) and isset($value['icon'])) {

            $value['icon'] = $this->iconReader->convert(0, $value['icon']);
        }

        return $value;
    }
}
 