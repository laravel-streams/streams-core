<?php namespace Anomaly\Streams\Platform\Ui\Button\Contract;

use Anomaly\Streams\Platform\Ui\Icon\Contract\IconInterface;

interface ButtonInterface
{

    public function setIcon(IconInterface $icon);

    public function getIcon();

    public function setClass($class);

    public function getClass();

    public function setSize($size);

    public function getSize();

    public function setText($text);

    public function getText();
}
 