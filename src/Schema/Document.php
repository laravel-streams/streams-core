<?php

namespace Streams\Core\Schema;

use GoldSpecDigital\ObjectOrientedOAS\Utilities\Arr;
use Streams\Core\Schema\Objects\Schema;

/**
 * @property string|null $schema
 */
class Document extends Schema
{
    const DRAFT2020_12 = 'https://json-schema.org/draft/2020-12/schema';
    const DRAFT2019_09 = 'https://json-schema.org/draft/2019-09/schema';

    /**
     * This keyword is used to specify the desired schema version.
     * The value of this keyword must be a string representing an URI.
     *
     * @link https://json-schema.org/specification-links.html
     * @var string
     */
    protected $schema = self::DRAFT2020_12;

    /**
     * This keyword is used to specify an unique ID for a document or a document subschemas.
     * The value of this keyword must be a string representing an URI.
     * All subschema IDs are resolved relative to the document’s ID.
     *
     * @var string
     */
    protected $id;


    public function schema(?string $uri): static
    {
        $instance = clone $this;

        $instance->schema = $uri;

        return $instance;
    }


    public function id(?string $id): static
    {
        $instance = clone $this;

        $instance->id = $id;

        return $instance;
    }


    public function defs(Schema ...$defs): static
    {
        $instance = clone $this;

        $instance->defs = $defs;

        return $instance;
    }

    protected function generate(): array
    {
        $generated = parent::generate();
        $data      = Arr::filter([
            '$schema' => $this->schema,
            '$id'     => $this->id,
            '$defs'   => $this->defs,
        ]);
        return array_merge($data, $generated);
    }

}
