<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Parser\EntryClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationFieldsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRulesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryStreamParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTableParser;
use Anomaly\Streams\Platform\Support\Generator;

class EntryGenerator extends Generator
{

    protected $class;

    protected $table;

    protected $rules;

    protected $stream;

    protected $relations;

    protected $namespace;

    protected $relationFields;

    public function __construct()
    {
        parent::__construct();

        $this->class          = new EntryClassParser();
        $this->table          = new EntryTableParser();
        $this->rules          = new EntryRulesParser();
        $this->stream         = new EntryStreamParser();
        $this->relations      = new EntryRelationsParser();
        $this->namespace      = new EntryNamespaceParser();
        $this->relationFields = new EntryRelationFieldsParser();
    }

    public function compile($template, $data)
    {
        $class          = $this->class->parse($data);
        $table          = $this->table->parse($data);
        $rules          = $this->rules->parse($data);
        $stream         = $this->stream->parse($data);
        $relations      = $this->relations->parse($data);
        $namespace      = $this->namespace->parse($data);
        $relationFields = $this->relationFields->parse($data);

        $data = compact('class', 'table', 'rules', 'stream', 'relations', 'namespace', 'relationFields');

        return parent::compile($template, $data);
    }
}
