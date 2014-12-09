<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Contract;

interface StreamsFieldInterface
{

    public function viewData(array $arguments = []);

    public function setField($field);

    public function getField();

    public function getStream();

    public function getEntry();

    public function getForm();
}
 