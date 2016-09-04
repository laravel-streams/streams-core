<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationRepository extends DatabaseMigrationRepository
{

    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon  = null;

    /**
     * Get ran migrations.
     *
     * @return array
     */
    public function getRan($namespace = null)
    {
        if ($addon = $this->getAddon()) {
            return $this->table()
                    ->orderBy('batch', 'asc')
                    ->orderBy('migration', 'asc')
                    ->where('migration', 'LIKE', '%' . $addon->getNamespace() . '%')
                    ->pluck('migration')->all();
        }

        return parent::getRan();
    }

    /**
     * Set the addon.
     *
     * @param Addon $addon
     */
    public function setAddon(Addon $addon)
    {
        $this->addon = $addon;

        return $this;
    }

    /**
     * Get the addon.
     *
     * @return Addon
     */
    public function getAddon()
    {
        return $this->addon;
    }
}
