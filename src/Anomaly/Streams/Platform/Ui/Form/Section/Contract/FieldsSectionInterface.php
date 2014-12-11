<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Contract;

interface FieldsSectionInterface
{
    public function viewData(array $arguments = []);

    public function setFields($fields);

    public function getFields();

    public function setStream($stream);

    public function getStream();

    public function setEntry($entry);

    public function getEntry();

    public function setTitle($title);

    public function getTitle();

    public function setForm($form);

    public function getForm();

    public function setView($view);

    public function getView();
}
