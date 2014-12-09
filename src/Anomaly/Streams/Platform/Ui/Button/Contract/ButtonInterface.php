<?php namespace Anomaly\Streams\Platform\Ui\Button\Contract;

interface ButtonInterface
{

    public function viewData(array $arguments = []);

    public function setAttributes($attributes);

    public function getAttributes();

    public function setClass($class);

    public function getClass();

    public function setIcon($icon);

    public function getIcon();

    public function setText($text);

    public function getText();

    public function setType($type);

    public function getType();
}
 