<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Parser\EntryClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryDatesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationFieldsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRulesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryStreamParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTableParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationForeignKeyParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationModelParser;
use Anomaly\Streams\Platform\Support\Generator;

class EntryGenerator extends Generator
{

    protected $class;

    protected $table;

    protected $rules;

    protected $dates;

    protected $stream;

    protected $relations;

    protected $namespace;

    protected $relationFields;

    protected $translationModel;

    protected $translationForeignKey;

    public function __construct()
    {
        parent::__construct();

        $this->class                 = new EntryClassParser();
        $this->table                 = new EntryTableParser();
        $this->rules                 = new EntryRulesParser();
        $this->dates                 = new EntryDatesParser();
        $this->stream                = new EntryStreamParser();
        $this->relations             = new EntryRelationsParser();
        $this->namespace             = new EntryNamespaceParser();
        $this->relationFields        = new EntryRelationFieldsParser();
        $this->translationModel      = new EntryTranslationModelParser();
        $this->translationForeignKey = new EntryTranslationForeignKeyParser();
    }

    public function compile($template, $data)
    {
        $class                 = $this->class->parse($data);
        $table                 = $this->table->parse($data);
        $rules                 = $this->rules->parse($data);
        $dates                 = $this->dates->parse($data);
        $stream                = $this->stream->parse($data);
        $relations             = $this->relations->parse($data);
        $namespace             = $this->namespace->parse($data);
        $relationFields        = $this->relationFields->parse($data);
        $translationModel      = $this->translationModel->parse($data);
        $translationForeignKey = $this->translationForeignKey->parse($data);

        $data = compact(
            'class',
            'table',
            'rules',
            'dates',
            'stream',
            'relations',
            'namespace',
            'relationFields',
            'translationModel',
            'translationForeignKey'
        );

        return parent::compile($template, $data);
    }
}
