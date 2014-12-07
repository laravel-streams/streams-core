<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsTableParser;
use Anomaly\Streams\Platform\Support\Generator;

/**
 * Class EntryTranslationsGenerator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryTranslationsGenerator extends Generator
{

    /**
     * The class parser.
     *
     * @var Parser\EntryTranslationsClassParser
     */
    protected $class;

    /**
     * The table parser.
     *
     * @var Parser\EntryTranslationsTableParser
     */
    protected $table;

    /**
     * The namespace parser.
     *
     * @var Parser\EntryNamespaceParser
     */
    protected $namespace;

    /**
     * Create a new EntryTranslationsGenerator instance.
     */
    public function __construct()
    {
        $this->namespace = new EntryNamespaceParser();
        $this->class     = new EntryTranslationsClassParser();
        $this->table     = new EntryTranslationsTableParser();
    }

    /**
     * Compile the template.
     *
     * @param $template
     * @param $stream
     * @return mixed
     */
    public function compile($template, $stream)
    {
        $class     = $this->class->parse($stream);
        $table     = $this->table->parse($stream);
        $namespace = $this->namespace->parse($stream);

        $stream = compact('class', 'table', 'namespace');

        return parent::compile($template, $stream);
    }
}
