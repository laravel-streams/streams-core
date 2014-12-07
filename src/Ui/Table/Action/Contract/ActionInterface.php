<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Icon\Contract\IconInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

interface ActionInterface
{

    public function handle(Table $table, array $ids);

    public function viewData();

    public function setAttributes(array $attributes);

    public function getAttributes();

    public function setIcon(IconInterface $icon);

    public function getIcon();

    public function setHandler($handler);

    public function getHandler();

    public function setActive($active);

    public function isActive();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setText($text);

    public function getText();

    public function setSlug($slug);

    public function getSlug();
}
 