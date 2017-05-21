<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\Parser\EntryClassParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryDatesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryFieldSlugsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryNamespaceParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationshipsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRelationsParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryRulesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntrySearchableParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryStreamParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTableParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTitleParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslatedAttributesParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationForeignKeyParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTranslationModelParser;
use Anomaly\Streams\Platform\Entry\Parser\EntryTrashableParser;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Collection;

class GetConfiguration
{
    /**
     * The stream interface.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new GetConfiguration instance.
     *
     * @param string $key
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     *
     * @param  Repository $cache
     * @return Collection
     */
    public function handle()
    {
        return new Collection([
            'data' => [
                'class'                   => (new EntryClassParser())->parse($this->stream),
                'title'                   => (new EntryTitleParser())->parse($this->stream),
                'table'                   => (new EntryTableParser())->parse($this->stream),
                'rules'                   => (new EntryRulesParser())->parse($this->stream),
                'dates'                   => (new EntryDatesParser())->parse($this->stream),
                'stream'                  => (new EntryStreamParser())->parse($this->stream),
                'trashable'               => (new EntryTrashableParser())->parse($this->stream),
                'relations'               => (new EntryRelationsParser())->parse($this->stream),
                'namespace'               => (new EntryNamespaceParser())->parse($this->stream),
                'field_slugs'             => (new EntryFieldSlugsParser())->parse($this->stream),
                'searchable'              => (new EntrySearchableParser())->parse($this->stream),
                'relationships'           => (new EntryRelationshipsParser())->parse($this->stream),
                'translation_model'       => (new EntryTranslationModelParser())->parse($this->stream),
                'translated_attributes'   => (new EntryTranslatedAttributesParser())->parse($this->stream),
                'translation_foreign_key' => (new EntryTranslationForeignKeyParser())->parse($this->stream),
                'use'                     => 'Anomaly\Streams\Platform\Entry\EntryModel',
                'extends'                 => 'EntryModel',
                'traits'                  => '',
                'properties'              => '',
            ],

            'templatePath' => __DIR__ . '/../../../resources/stubs/models/entry.stub',
        ]);
    }
}