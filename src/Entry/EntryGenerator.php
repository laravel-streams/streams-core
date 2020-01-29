<?php

namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;

/**
 * Class EntryGenerator
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class EntryGenerator
{

    /**
     * Recompile entry models for a given stream.
     *
     * @param StreamInterface $stream
     */
    public static function generate(StreamInterface $stream)
    {
        $data = new Collection(
            [
                'with'                    => self::generateWith($stream),
                'class'                   => self::generateClass($stream),
                'title'                   => self::generateTitle($stream),
                'table'                   => self::generateTable($stream),
                'dates'                   => self::generateDates($stream),
                'casts'                   => self::generateCasts($stream),
                'stream'                  => self::generateStream($stream),
                'trashable'               => self::generateTrashable($stream),
                'relations'               => self::generateRelations($stream),
                'namespace'               => self::generateNamespace($stream),
                'field_slugs'             => self::generateFieldSlugs($stream),
                'searchable'              => self::generateSearchable($stream),
                'versionable'             => self::generateVersionable($stream),
                'relationships'           => self::generateRelationships($stream),
                'translated_attributes'   => self::generateTranslatedAttributes($stream),
            ]
        );

        $template = $data->pull(
            'template',
            file_get_contents(__DIR__ . '/../../resources/stubs/models/entry.stub')
        );

        $path = app_storage_path('models/' . studly_case($stream->getNamespace()));

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $path . '/'
            . studly_case($stream->getNamespace())
            . studly_case($stream->getSlug())
            . 'EntryModel.php';

        if (!is_dir($path = dirname($file))) {
            mkdir($path, 0777, true);
        }

        if (file_exists($file)) {
            unlink($file);
        }

        file_put_contents($file, parse($template, $data->toArray()));
    }

    /**
     * Parse the relation methods.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateWith(StreamInterface $stream)
    {
        $relationships = [];

        return '[' . implode(', ', $relationships) . ']';
    }

    /**
     * Return the entry model class.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateClass(StreamInterface $stream)
    {
        return studly_case("{$stream->getNamespace()}_{$stream->getSlug()}") . 'EntryModel';
    }

    /**
     * Return the title key for an entry model.
     *
     * @param  StreamInterface $stream
     * @return mixed
     */
    protected static function generateTitle(StreamInterface $stream)
    {
        return $stream->getTitleColumn();
    }

    /**
     * Return the entry table name.
     *
     * @param  StreamInterface $stream
     * @return mixed
     */
    protected static function generateTable(StreamInterface $stream)
    {
        return $stream->getEntryTableName();
    }

    /**
     * Return the dates attribute.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateDates(StreamInterface $stream)
    {
        $dates = [];

        $dates[] = "'created_at'";
        $dates[] = "'updated_at'";

        /* @var AssignmentInterface $assignment */
        foreach ($stream->getDateAssignments() as $assignment) {
            $dates[] = "'{$assignment->getFieldSlug()}'";
        }

        if ($stream->isTrashable()) {
            $dates[] = "'deleted_at'";
        }

        return "[" . implode(', ', $dates) . "]";
    }

    /**
     * Return the casts attribute.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateCasts(StreamInterface $stream)
    {
        $casts = [];

        /* @var AssignmentInterface $assignment */
        foreach ($stream->getTranslatableAssignments() as $assignment) {
            $casts[] = "'{$assignment->getFieldSlug()}' => 'array'";
        }

        return "[" . implode(', ', $casts) . "]";
    }

    /**
     * Parse the stream data.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateStream(StreamInterface $stream)
    {
        return "{$stream->namespace}.{$stream->slug}";
        $string = '[';

        self::parseStream($stream, $string);
        self::parseAssignments($stream, $string);

        $string .= "\n]";

        return $string;
    }

    /**
     * Return the use statement for trashable if so.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateTrashable(StreamInterface $stream)
    {
        if (!$stream->isTrashable()) {
            return null;
        }

        return "use \\Illuminate\\Database\\Eloquent\\SoftDeletes;";
    }

    /**
     * Parse the relation methods.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateRelations(StreamInterface $stream)
    {
        $string = '';

        $assignments = $stream->getAssignments();

        foreach ($assignments->relations() as $assignment) {
            self::parseRelation($assignment, $string);
        }

        return $string;
    }

    /**
     * Return the entry model base namespace.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateNamespace(StreamInterface $stream)
    {
        return studly_case($stream->getNamespace());
    }

    /**
     * Return the entry model base namespace.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateFieldSlugs(StreamInterface $stream)
    {
        $string = "[";

        foreach ($stream->getAssignmentFieldSlugs() as $slug) {
            $string .= "\n        '{$slug}',";
        }

        $string .= "\n]";

        return $string;
    }

    /**
     * Return the use statement for trashable if so.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateSearchable(StreamInterface $stream)
    {
        if (!$stream->isSearchable()) {
            return "false";
        }

        return "true";
    }

    /**
     * Return the value for versionable property.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    protected static function generateVersionable(StreamInterface $stream)
    {
        if (!$stream->isVersionable()) {
            return 'false';
        }

        return 'true';
    }

    /**
     * Return the relationships attribute.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    public static function generateRelationships(StreamInterface $stream)
    {
        $relationships = [];

        /* @var AssignmentInterface $assignment */
        foreach ($stream->getRelationshipAssignments() as $assignment) {
            $relationships[] = "'{$assignment->getFieldSlug()}'";
        }

        return "[" . implode(', ', $relationships) . "]";
    }

    /**
     * Return the translation foreign key attribute.
     *
     * @param  StreamInterface $stream
     * @return null|string
     */
    public static function generateTranslatedAttributes(StreamInterface $stream)
    {
        if (!$stream->isTranslatable()) {
            return null;
        }

        $assignments = $stream->getTranslatableAssignments();

        if ($assignments->isEmpty()) {
            return null;
        }

        return 'protected $translatedAttributes = [\'' . $assignments->fieldSlugs()->implode('\', \'') . '\'];';
    }

    /**
     * Parse an assignment relation.
     *
     * @param AssignmentInterface $assignment
     * @param                     $string
     */
    protected static function parseRelation(AssignmentInterface $assignment, &$string)
    {
        $fieldType = $assignment->getFieldType();

        $parser = $fieldType->getParser();

        $string .= $parser->relation($assignment);
    }

    /**
     * Append the assignment rules.
     *
     * @param StreamInterface     $stream
     * @param AssignmentInterface $assignment
     * @param                     $string
     */
    protected static function appendAssignmentRules(StreamInterface $stream, AssignmentInterface $assignment, &$string)
    {
        $rules = [];

        if ($assignment->isRequired()) {
            $rules[] = 'required';
        }

        if ($assignment->isUnique()) {
            $rules[] = 'unique:' . $stream->getEntryTableName() . ',' . $assignment->getColumnName();
        }

        if (is_array($rules)) {

            $rules = implode('|', array_filter($rules));

            $fieldSlug = $assignment->getFieldSlug();

            $string .= "\n        '{$fieldSlug}' => '{$rules}',";
        }
    }

    /**
     * Prepare a string value.
     *
     * @param string $value
     */
    public static function prepareStringValue(string $value)
    {
        return str_replace('\\', '\\\\', $value);
    }
}
