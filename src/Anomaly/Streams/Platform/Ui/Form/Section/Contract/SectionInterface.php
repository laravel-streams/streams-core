<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Contract;

interface SectionInterface
{

    public function viewData(array $arguments = []);

    public function setBody($body);

    public function getBody();

    public function setTitle($title);

    public function getTitle();

    public function setView($view);

    public function getView();
}
 