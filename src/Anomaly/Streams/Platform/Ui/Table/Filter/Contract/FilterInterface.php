<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function handle(Table $table, Builder $query);

    public function viewData(array $arguments = []);

    public function setPlaceholder($placeholder);

    public function getPlaceholder();

    public function setHandler($handler);

    public function getHandler();

    public function setActive($active);

    public function isActive();

    public function setPrefix($prefix);

    public function getPrefix();

    public function setSlug($slug);

    public function getSlug();
}
