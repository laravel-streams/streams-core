<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;

/**
 * Class FieldController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldController extends AdminController
{

    public function change(FieldTypeCollection $fieldTypes)
    {
        return $this->view->make(
            'streams::fields/change',
            [
                'field_types' => $fieldTypes->filter(
                    function (FieldType $fieldType) {
                        return $fieldType->getColumnType() !== false;
                    }
                ),
            ]
        );
    }
}
