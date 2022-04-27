<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Illuminate\Support\Collection;
use Streams\Core\Field\Schema\ArrSchema;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Field\Decorator\ArrayDecorator;

class ArrayFieldType extends Field
{
    protected $__attributes = [
        'rules' => [
            'array',
        ],
    ];

    public function cast($value)
    {
        if (is_object($value)) {
            return $value;
        }

        if (is_string($value) && ($json = json_decode($value, true)) !== null) {
            $value = $json;
        }

        if (is_string($value) && Str::isSerialized($value)) {
            $value = unserialize($value);
        }

        if (is_string($value)) {
            $value = (array) $value;
        }

        if ($wrapper = $this->config('wrapper')) {
            $value = $this->wrapArray($value, $wrapper);
        }

        return $value;
    }

    public function modify($value)
    {
        foreach ($value as &$item) {

            if (is_object($item) && $item instanceof EntryInterface) {
                $item = [
                    '@stream' => $item->stream()->id,
                ] + $item->getAttributes();
            }

            if (
                is_object($item) && ($item instanceof Arrayable
                || in_array(Prototype::class, class_uses($item)))
            ) {
                $item = array_merge([
                    '@abstract' => get_class($item),
                ], $item->toArray());
            }

            if (is_object($item)) {
                $item = Hydrator::dehydrate($item);
            }
        }

        return $value;
    }

    public function restore($value)
    {
        foreach ((array) $value as &$item) {

            if (!is_array($item) && $stream = $this->config('related')) {
                
                $item = Streams::repository($stream)->find($item);

                continue;
            }
            
            if (!is_array($item)) {
                continue;
            }

            [$meta, $item] = $this->separateMeta($item);

            if (!$meta && $stream = $this->config('stream')) {

                // @todo gross
                if (is_array($stream)) {
                    $item = Streams::build($stream)->repository()->newInstance($item);
                } else {
                    $item = Streams::repository($stream)->newInstance($item);
                }

                continue;
            }

            // @todo eager loading
            if (!$meta && $stream = $this->config('related')) {

                $item = Streams::repository($stream)->find($item);

                continue;
            }

            if (isset($meta['@stream'])) {

                $item = $this->restoreStreamEntry($meta, $item);

                continue;
            }

            if (isset($meta['@abstract'])) {
                
                $item = $this->restoreInstance($meta, $item);

                continue;
            }
        }

        if ($wrapper = $this->config('wrapper')) {
            $value = $this->wrapArray($value, $wrapper);
        }
        
        return $value;
    }

    public function getDecoratorName()
    {
        return ArrayDecorator::class;
    }

    // public function getSchemaName()
    // {
    //     return ArrSchema::class;
    // }

    // public function generate()
    // {
    //     for ($i = 0; $i < 10; $i++) {
    //         $values[] = $this->generator()->randomElement([
    //             $this->generator()->word(),
    //             $this->generator()->randomNumber(),
    //         ]);
    //     }

    //     return $values;
    // }

    protected function wrapArray($array, $wrapper)
    {
        if ($wrapper == 'collection') {
            return new Collection($array);
        }

        return new $wrapper($array);
    }

    protected function separateMeta(array $value)
    {
        $meta = preg_grep('/^\@/', array_keys($value));

        $meta = array_intersect_key($value, array_flip($meta));

        array_map(function ($key) use (&$value) {
            unset($value[$key]);
        }, array_keys($meta));

        return [$meta, $value];
    }

    protected function restoreStreamEntry(array $meta, array $value)
    {
        return Streams::repository($meta['@stream'])->newInstance($value);
    }

    protected function restoreInstance(array $meta, array $value)
    {
        return new $meta['@abstract']($value);
    }
}
