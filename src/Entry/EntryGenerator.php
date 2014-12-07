<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Parser\EntryClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryDatesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationFieldsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRulesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryStreamParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTableParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTitleParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationForeignKeyParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationModelParser;
use Anomaly\Streams\Platform\Support\Generator;

/**
 * Class EntryGenerator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryGenerator extends Generator
{

    /**
     * The class parser.
     *
     * @var Parser\EntryClassParser
     */
    protected $class;

    /**
     * The title parser.
     *
     * @var Parser\EntryTitleParser
     */
    protected $title;

    /**
     * The table parser.
     *
     * @var Parser\EntryTableParser
     */
    protected $table;

    /**
     * The rules parser.
     *
     * @var Parser\EntryRulesParser
     */
    protected $rules;

    /**
     * The dates parser.
     *
     * @var Parser\EntryDatesParser
     */
    protected $dates;

    /**
     * The stream parser.
     *
     * @var Parser\EntryStreamParser
     */
    protected $stream;

    /**
     * The relations parser.
     *
     * @var Parser\EntryRelationsParser
     */
    protected $relations;

    /**
     * The namespace parser.
     *
     * @var Parser\EntryNamespaceParser
     */
    protected $namespace;

    /**
     * The translation parser.
     *
     * @var Parser\EntryTranslationModelParser
     */
    protected $translationModel;

    /**
     * The translation foreign key parser.
     *
     * @var Parser\EntryTranslationForeignKeyParser
     */
    protected $translationForeignKey;

    /**
     * Create a new EntryGenerator instance.
     */
    public function __construct()
    {
        $this->class                 = new EntryClassParser();
        $this->title                 = new EntryTitleParser();
        $this->table                 = new EntryTableParser();
        $this->rules                 = new EntryRulesParser();
        $this->dates                 = new EntryDatesParser();
        $this->stream                = new EntryStreamParser();
        $this->relations             = new EntryRelationsParser();
        $this->namespace             = new EntryNamespaceParser();
        $this->translationModel      = new EntryTranslationModelParser();
        $this->translationForeignKey = new EntryTranslationForeignKeyParser();
    }

    /**
     * Compile the template.
     *
     * @param $template
     * @param $data
     * @return mixed
     */
    public function compile($template, $data)
    {
        $class                 = $this->class->parse($data);
        $title                 = $this->title->parse($data);
        $table                 = $this->table->parse($data);
        $rules                 = $this->rules->parse($data);
        $dates                 = $this->dates->parse($data);
        $stream                = $this->stream->parse($data);
        $relations             = $this->relations->parse($data);
        $namespace             = $this->namespace->parse($data);
        $translationModel      = $this->translationModel->parse($data);
        $translationForeignKey = $this->translationForeignKey->parse($data);

        $data = compact(
            'class',
            'title',
            'table',
            'rules',
            'dates',
            'stream',
            'relations',
            'namespace',
            'translationModel',
            'translationForeignKey'
        );

        return parent::compile($template, $data);
    }
}
