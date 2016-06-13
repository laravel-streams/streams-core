<?php namespace Anomaly\Streams\Platform\Database\Seeder\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Anomaly\Streams\Platform\Support\Presenter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeedHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Seeder\Command
 */
class SeedHandler
{

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * The seeder utility.
     *
     * @var Seeder
     */
    protected $seeder;

    /**
     * Create a new SeedHandler instance.
     *
     * @param AddonCollection $addons
     * @param Seeder          $seeder
     */
    public function __construct(AddonCollection $addons, Seeder $seeder)
    {
        $this->addons = $addons;
        $this->seeder = $seeder;
    }

    /**
     * Handle the command.
     *
     * @param Seed $command
     */
    public function handle(Seed $command)
    {
        $this->seeder->setContainer(app());
        $this->seeder->setCommand($command->getCommand());

        Model::unguard();

        $class = $command->getClass();
        $addon = $this->addons->get($command->getAddon());

        /**
         * Depending on when this is called, and
         * how seeding uses the view layer the addon's
         * could be decorated, so un-decorate them real
         * quick before proceeding.
         */
        if ($addon && $addon instanceof Presenter) {
            $addon = $addon->getObject();
        }

        /**
         * If the addon was passed then
         * get it and seed it.
         */
        if ($addon) {
            $this->call($this->getSeederClass($addon));
        }

        /**
         * If a seeder class was passed then
         * call it from the seeder utility.
         */
        if (!$addon && $class) {
            $this->call($class);
        }
    }

    /**
     * Call a seeder if it exists.
     *
     * @param $class
     */
    protected function call($class)
    {
        if (class_exists($class)) {
            $this->seeder->call($class);
        }
    }

    /**
     * Get the seeder class for an addon.
     *
     * @param Addon $addon
     * @return string
     */
    protected function getSeederClass(Addon $addon)
    {
        return get_class($addon) . 'Seeder';
    }
}
