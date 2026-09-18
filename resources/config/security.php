<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    |
    | CSRF configuration
    |
    */

    'csrf' => [
        'except' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Display HTML
    |--------------------------------------------------------------------------
    |
    | The HTML permitted in text that is displayed as markup rather than
    | escaped, such as a field's label, instructions and warning. Those
    | come from the field definition, which is editable in the admin,
    | so they are purified against this list before being output.
    |
    | Set "allowed" to an empty string to permit no HTML at all.
    |
    */

    'display' => [
        'allowed' => 'strong,b,em,i,br,code,a[href|title|target]',
        'targets' => ['_blank'],
    ],

];
