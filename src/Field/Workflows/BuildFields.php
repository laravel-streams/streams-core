<?php

namespace Anomaly\Streams\Platform\Field\Workflows;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Field\Field;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Platform\Field\FieldCollection;

/**
 * Class BuildFields
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFields extends Workflow
{

    protected $steps = [
        'normalize' => BuildFields::class . '@normalize',
        'make' => BuildFields::class . '@make',
    ];

    public function normalize($workflow)
    {
        $fields = $workflow->fields;

        foreach ($fields as $handle => &$input) {
            
            if (is_string($input)) {
                $input = [
                    'type' => $input,
                ];
            }

            if (!isset($input['handle'])) {
                $input['handle'] = $handle;
            }

            // INPUT TEST
            // @todo replace
            if (strpos($input['type'], '|')) {
                list($input['type'], $input['input']) = explode('|', $input['type']);
            } else {
                $input['input'] = $input['type'];
            }

            $input['rules'] = array_map(function ($rules) {

                if (is_string($rules)) {
                    return explode('|', $rules);
                }
    
                return $rules;
            }, Arr::get($input, 'rules', []));
        }
        
        $workflow->fields = $fields;
    }

    public function make($workflow)
    {
        $collection = new FieldCollection();

        foreach ($workflow->fields as $field) {

            $field = new Field($field);

            $collection->put($field->handle, $field);
        }

        $workflow->fields = $collection;
    }
}
