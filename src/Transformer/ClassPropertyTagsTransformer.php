<?php

namespace Streams\Core\Transformer;

use Barryvdh\Reflection\DocBlock;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\ContextFactory;
use phpDocumentor\Reflection\Types\Mixed_;
use ReflectionClass;
use Spatie\LaravelTypeScriptTransformer\Transformers\DtoTransformer;
use Spatie\TypeScriptTransformer\Structures\MissingSymbolsCollection;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfig;
use function collect;

class ClassPropertyTagsTransformer extends DtoTransformer
{
    /**
     * @var \phpDocumentor\Reflection\Types\ContextFactory
     */
    protected $contextFactory;

    /**
     * @var \phpDocumentor\Reflection\TypeResolver
     */
    protected $typeResolver;

    public function __construct(TypeScriptTransformerConfig $config)
    {
        parent::__construct($config);
        $this->contextFactory = new ContextFactory();
        $this->typeResolver   = new TypeResolver();
    }

    protected function transformProperties(
        ReflectionClass          $class,
        MissingSymbolsCollection $missingSymbols
    ): string
    {
        /** @var \Illuminate\Support\Collection|array<string,\Barryvdh\Reflection\DocBlock\Tag\PropertyTag> $tags */
        $tags = collect();
        foreach (array_merge($this->getParentClasses($class), [ $class ]) as $parent) {
            $tags = $this->getClassDocPropertiesTags($parent)->replace($tags);
        }
        return array_reduce(
            $tags->toArray(),
            function (string $carry, DocBlock\Tag\PropertyTag $tag) use ($missingSymbols, $class) {
                $type        = $this->getTagType($tag, $class);
                $transformed = $this->typeToTypeScript($type, $missingSymbols, $class);

                if ($transformed === null) {
                    return $carry;
                }

                $name = str_replace('$', '', $tag->getVariableName());
                return "{$carry}{$name}: {$transformed};" . PHP_EOL;
            },
            ''
        );
    }

    /**
     * @param \ReflectionClass $class
     * @return \Illuminate\Support\Collection|array<string,\Barryvdh\Reflection\DocBlock\Tag\PropertyTag>
     */
    protected function getClassDocPropertiesTags(ReflectionClass $class)
    {
        $db   = new DocBlock($class->getDocComment());
        $tags = $db->getTagsByName('property');
        return collect($tags)->mapWithKeys(function (DocBlock\Tag\PropertyTag $tag) {
            return [ $tag->getVariableName() => $tag ];
        });
    }

    /**
     * @param \Barryvdh\Reflection\DocBlock\Tag $tag
     * @param \ReflectionClass                  $class
     * @return \phpDocumentor\Reflection\Type
     */
    protected function getTagType(DocBlock\Tag $tag, ReflectionClass $class)
    {
        try {
            return $this->typeResolver->resolve($tag->getType(), $this->contextFactory->createFromReflector($class));
        }
        catch (\Throwable $e) {
            return new Mixed_();
        }
    }

    protected function getParentClasses(ReflectionClass $class)
    {
        $parent  = $class;
        $parents = [];
        while ($parent) {
            $parent = $parent->getParentClass();
            if ($parent) {
                $parents[] = $parent;
            }
        }
        return array_reverse($parents);
    }

}
