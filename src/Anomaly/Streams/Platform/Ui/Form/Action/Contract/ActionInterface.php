<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Contract;

use Anomaly\Streams\Platform\Ui\Form\Form;

interface ActionInterface
{
    public function handle(Form $form);

    public function viewData(array $arguments = []);

    public function setHandler($handler);

    public function getHandler();

    public function setActive($active);

    public function isActive();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setSlug($slug);

    public function getSlug();
}
