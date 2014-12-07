<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Type;

use Anomaly\Streams\Platform\Ui\Form\Field\FieldCollection;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

class FieldsSection implements SectionInterface
{

    protected $fields;

    function __construct(FieldCollection $fields)
    {
        $this->fields = $fields;
    }

    public function viewData()
    {
        // TODO: Implement viewData() method.
    }
}
 