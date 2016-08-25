<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

/**
 * Class TransformMigrationNameToClass
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class TransformMigrationNameToClass
{

    /**
     * The migration name.
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new TransformMigrationNameToClass instance.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Handle the command.
     *
     * @param  TransformMigrationNameToClass $command
     * @return string
     */
    public function handle()
    {
        $transformed = studly_case(str_replace('.', '_', basename($this->name, '.php')));

        $segments = explode('__', $this->name);

        // Insert the version number if there are three segments or more
        if (count($segments) >= 3) {
            $key       = $segments[0];
            $version   = $segments[1];
            $migration = $segments[2];

            $transformed =
                studly_case(str_replace('.', '_', $key)) . '_' .
                str_replace('.', '_', $version) . '_' .
                studly_case(str_replace('.', '_', $migration));
        }
        
        return $transformed;
    }
}
