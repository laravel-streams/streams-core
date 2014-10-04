<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Model\EloquentModel;

class ModuleModel extends EloquentModel
{
    /**
     * Define the table name.
     *
     * @var string
     */
    protected $table = 'addons_modules';
}
