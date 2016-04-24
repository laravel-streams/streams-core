<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class InstallModulesTableHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModulesTableHandler
{

    /**
     * The schema builder object.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new InstallModulesTableHandler instance.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Install the modules table.
     */
    public function handle()
    {
        $this->schema->dropIfExists('addons_modules');

        $this->schema->create(
            'addons_modules',
            function (Blueprint $table) {

                $table->increments('id');
                $table->string('slug');
                $table->boolean('installed')->default(0);
                $table->boolean('enabled')->default(0);
            }
        );
    }
}
