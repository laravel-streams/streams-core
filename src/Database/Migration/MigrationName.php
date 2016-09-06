<?php namespace Anomaly\Streams\Platform\Database\Migration;

class MigrationName
{

    /**
     * The migration file name.
     *
     * @var string
     */
    protected $file;

    /**
     * Create a new MigrationFile
     *
     * @param string $file The migration file name
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Return the filename without the date prefix.
     *
     * @return string The file name without date prefix.
     */
    public function withoutDatePrefix()
    {
        $parts = explode('_', basename($this->file));

        $numeric = array_filter(array_slice($parts, 0, 4), function ($value) {
            return is_numeric($value);
        });

        if (count($numeric) !== 4) {
            return $this->file;
        }

        return implode('_', array_slice($parts, 4));
    }

    /**
     * Return the namespace of the migration filename.
     *
     * @return string
     */
    public function addonNamespace()
    {
        $segments = explode('__', $this->withoutDatePrefix());

        return $segments[0];
    }

    /**
     * Return the class name for the migration file.
     *
     * @return string
     */
    public function className()
    {
        return studly_case(str_replace('.', '_', basename($this->withoutDatePrefix(), '.php')));
    }

    /**
     * Return the migration name for the migration file.
     *
     * @return string
     */
    public function migration()
    {
        return basename($this->file, '.php');
    }
}
