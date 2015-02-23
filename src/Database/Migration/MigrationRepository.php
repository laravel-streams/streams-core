<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationRepository extends DatabaseMigrationRepository
{

    /**
     * @param        $namespace
     * @param string $order
     *
     * @return array|static[]
     */
    public function findManyByNamespace($namespace, $order = 'desc')
    {
        $query = $this->table()->where('migration', 'like', "%_{$namespace}_%");

        return $query->orderBy('migration', $order)->get();
    }

}