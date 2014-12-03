<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;

interface FilterInterface
{

    public function handle(Table $table);

    public function setHandler($handler);

    public function getHandler();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setSlug($slug);

    public function getSlug();
}
 