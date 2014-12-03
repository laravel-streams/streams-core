<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

class ParseColumnInputCommandHandler
{

    public function handle(ParseColumnInputCommand $command)
    {
        $columns = $command->getColumns();

        foreach ($columns as $key => &$value) {

            $value = $this->parse($key, $value);
        }

        return array_values($columns);
    }

    protected function parse($key, $value)
    {
        /**
         * If the key is numeric and the value is
         * a string then use the value as both the
         * column field and value.
         */
        if (is_numeric($key) and is_string($value)) {

            return [
                'field' => $value,
                'value' => $value,
            ];
        }

        /**
         * If the key IS the field and the value is a
         * string then use the key as the field and the
         * value as the column value.
         */
        if (!is_numeric($key) and is_string($value)) {

            return [
                'field' => $key,
                'value' => $value,
            ];
        }

        /**
         * If the key is a field and the value is an
         * array without a field then use the key for
         * the field here.
         */
        if (is_array($value) and !isset($value['field']) and !is_numeric($key)) {

            $value['field'] = $key;
        }

        return $value;
    }
}
 