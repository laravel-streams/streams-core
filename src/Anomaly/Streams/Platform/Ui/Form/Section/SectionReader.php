<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Field\FieldReader;

class SectionReader
{

    protected $fieldReader;

    function __construct(FieldReader $fieldReader)
    {
        $this->fieldReader = $fieldReader;
    }

    public function convert($key, $value)
    {
        if (isset($value['fields'])) {

            foreach ($value['fields'] as $key => &$field) {

                $field = $this->fieldReader->convert($key, $field);
            }
        }

        if (isset($value['fields']) and !isset($value['section'])) {

            $value['section'] = 'fields';
        }

        return $value;
    }
}
 