<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

class ParseActionInputCommandHandler
{

    public function handle(ParseActionInputCommand $command)
    {
        $actions = $command->getActions();

        foreach ($actions as $key => &$value) {

            $value = $this->parse($key, $value);
        }

        return array_values($actions);
    }

    protected function parse($key, $value)
    {
        /**
         * If the key is not the slug and the value is
         * a string then treat the string as both the
         * action and the slug. This is OK as long as
         * there are not multiple instances of this
         * input using the same action which is not likely.
         */
        if (is_numeric($key) and is_string($value)) {

            return [
                'slug'   => $value,
                'action' => $value,
            ];
        }

        /**
         * If the key IS the slug and the value is a
         * string then use the key as the slug and the
         * value as the action.
         */
        if (!is_numeric($key) and is_string($value)) {

            return [
                'slug'   => $key,
                'action' => $value,
            ];
        }

        /**
         * If the key is a slug and the value is an
         * array without a slug then use the key for
         * the slug here.
         */
        if (is_array($value) and !isset($value['slug']) and !is_numeric($key)) {

            $value['slug'] = $key;
        }

        return $value;
    }
}
 