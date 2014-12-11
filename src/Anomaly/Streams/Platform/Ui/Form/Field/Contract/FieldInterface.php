<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Contract;

interface FieldInterface
{
    public function viewData(array $arguments = []);

    public function setInstructions($instructions);

    public function getInstructions();

    public function setPlaceholder($placeholder);

    public function getPlaceholder();

    public function setConfig(array $config);

    public function getConfig();

    public function setRules(array $rules);

    public function getRules();

    public function setInclude($include);

    public function getInclude();

    public function setLabel($label);

    public function getLabel();

    public function getForm();

    public function setValue($value);

    public function getValue();

    public function setSlug($slug);

    public function getSlug();

    public function setType($type);

    public function getType();
}
