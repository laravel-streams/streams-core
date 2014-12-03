<?php namespace Anomaly\Streams\Platform\Ui\Button\Command;

class ParseButtonInputCommandHandler
{

    public function handle(ParseButtonInputCommand $command)
    {
        $buttons = $command->getButtons();

        foreach ($buttons as $key => &$value) {

            $value = $this->parse($key, $value);
        }

        return array_values($buttons);
    }

    protected function parse($key, $value)
    {
        /**
         * If the key is not the button and the value
         * is a string then it IS the button.
         */
        if (is_numeric($key) and is_string($value)) {

            return [
                'button' => $value,
            ];
        }

        /**
         * If the key IS the button and the value is
         * a string then the value becomes the text.
         */
        if (!is_numeric($key) and is_string($value)) {

            return [
                'button' => $key,
                'text'   => $value,
            ];
        }

        /**
         * If the key is a button and the value is an
         * array without a button then use the key for
         * the button here.
         */
        if (is_array($value) and !isset($value['slug']) and !is_numeric($key)) {

            $value['slug'] = $key;
        }

        return $value;
    }
}
 