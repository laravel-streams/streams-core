<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

interface ActionInterface extends ButtonInterface
{
    public function setActive($active);

    public function getActive();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setSlug($slug);

    public function getSlug();
}
