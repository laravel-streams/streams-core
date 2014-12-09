<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;

interface ActionInterface
{

    public function viewData(array $arguments = []);

    public function handle(Table $table, array $ids);

    public function setAttributes($attributes);

    public function getAttributes();

    public function setHandler($handler);

    public function getHandler();

    public function setActive($active);

    public function getActive();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setIcon($icon);

    public function getIcon();

    public function setSlug($slug);

    public function getSlug();

    public function setText($text);

    public function getText();
}
 