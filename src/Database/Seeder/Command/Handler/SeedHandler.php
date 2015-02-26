<?php namespace Anomaly\Streams\Platform\Database\Seeder\Command\Handler;


use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Seeder\Command\Seed;
use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeedHandler
 *
 * @package Anomaly\Streams\Platform\Database\Seeder\Command\Handler
 */
class SeedHandler
{

    /**
     * @var Seeder
     */
    protected $seeder;

    /**
     * @var AddonCollection
     */
    protected $addons;

    /**
     * @param Seeder          $seeder
     * @param AddonCollection $addons
     */
    public function __construct(Seeder $seeder, AddonCollection $addons)
    {
        $this->seeder = $seeder;
        $this->addons = $addons;
    }

    /**
     * @param Seed $command
     */
    public function handle(Seed $command)
    {
        $this->seeder->setCommand($command->getConsoleCommand());

        Model::unguard();

        $addons = $this->addons->merged();

        if ($addon = $addons->get($command->getAddonNamespace())) {

            $this->call($this->getSeederClass($addon));

        } elseif ($class = $command->getClass()) {

            $this->call($class);

        } else {

            foreach ($addons as $addon) {

                $this->call($this->getSeederClass($addon));
            }
        }
    }

    /**
     * @param $class
     */
    protected function call($class)
    {
        if (class_exists($class)) {

            $this->seeder->call($class);
        }
    }

    /**
     * @param Addon $addon
     *
     * @return string
     */
    protected function getSeederClass(Addon $addon)
    {
        return get_class($addon) . 'Seeder';
    }

}