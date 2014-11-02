<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationsTableParser;
use Anomaly\Streams\Platform\Support\Generator;

class EntryTranslationsGenerator extends Generator
{

    protected $class;

    protected $table;

    protected $namespace;

    public function __construct()
    {
        parent::__construct();

        $this->namespace = new EntryNamespaceParser();
        $this->class     = new EntryTranslationsClassParser();
        $this->table     = new EntryTranslationsTableParser();
    }

    public function compile($template, $data)
    {
        $class     = $this->class->parse($data);
        $table     = $this->table->parse($data);
        $namespace = $this->namespace->parse($data);

        $data = compact('class', 'table', 'namespace');

        return parent::compile($template, $data);
    }
}
