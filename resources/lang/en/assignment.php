<?php

return [
    'label'        => [
        'name'         => 'Label',
        'instructions' => 'Label\'s will be used for forms only. If left blank, the field name will be used.'
    ],
    'required'     => [
        'name'         => 'Required',
        'label'        => 'Is this field required?',
        'instructions' => 'If required, this field MUST have a value at all times.'
    ],
    'unique'       => [
        'name'         => 'Unique',
        'label'        => 'Is this field unique?',
        'instructions' => 'If unique, this field MUST have a unique value.'
    ],
    'translatable' => [
        'name'  => 'Translatable',
        'label' => 'Is this field translatable?'
    ],
    'instructions' => [
        'name'         => 'Instructions',
        'instructions' => 'Field instructions will be displayed in forms to assist users.'
    ]
];
