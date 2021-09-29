<?php

namespace Streams\Core\Transformer;

use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\Context;
use ReflectionClass;
use Spatie\TypeScriptTransformer\Actions\TranspileTypeToTypeScriptAction;
use Streams\Ui\Button\Button;

class Typescript
{
    /** @var string */
    protected $class;

    /** @var ReflectionClass */
    protected $reflection;

    protected $ignoreProperties = [];

    protected $propertiesRequired = false;

    protected $intend = 4;

    /** @var array<string, array<string, array>> */
    protected $results = [];

    public function __construct(string $class)
    {
        $this->class      = $class;
        $this->reflection = new ReflectionClass($class);
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

    public function transform()
    {
        return $this->transformClass($this->reflection);
    }

    protected function transformClass(ReflectionClass $class)
    {
        $result = $this->getClassProperties($class);
        foreach ($result->missing->all() as $missing) {
            foreach ($result->properties as &$property) {

                if (Str::contains($property['type'], "{%$missing%}")) {
                    if(!class_exists($missing)){
                        $property[ 'type' ] = 'any';
                        $result->missing->remove($missing);
                        continue;
                    }
                    $reflection = new ReflectionClass($missing);
                    $this->transformClass($reflection);
                    $result->missing->remove($missing);
                    $property[ 'type' ] =str_replace("{%$missing%}", $reflection->getShortName(), $property['type']);
                }
            }
        }
        $this->results[ $class->getShortName() ] = $this->createInterface($class->getShortName(), $result->properties);
        return $this->results;
    }

    public function createInterface(string $name, array $properties, $export = true)
    {
        $delimiter = $this->propertiesRequired ? ':' : '?:';
        $props     = array_map(function (array $prop) use ($delimiter) {
            $intend = str_repeat(' ', $this->intend);
            $line   = "";
            if ($prop[ 'description' ] !== '') {
                $line = "{$intend}/** {$prop['description']} */\n";
            }
            $line .= "{$intend}{$prop['name']}{$delimiter} {$prop['type']}";
            return $line;
        }, $properties);
        $body      = implode("\n\n", $props);
        $line      = "interface {$name} {\n";
        if ($export) {
            $line = "export " . $line;
        }
        return $line . $body . "\n}";
    }

    /** @noinspection SlowArrayOperationsInLoopInspection */
    protected function getClassProperties(ReflectionClass $class)
    {
        $result  = new Result($class);
        $parents = $this->getParentClasses($class);
        foreach ($parents as $parent) {
            $parentResult = $this->getClassProperties($parent);
            foreach ($parentResult->missing->all() as $missing) {
                $result->missing->add($missing);
            }
            $result->properties = array_replace($result->properties, $parentResult->properties);
        }
        $docComment = $class->getDocComment();
        $factory  = DocBlockFactory::createInstance();
        $typeTranspiler = new TranspileTypeToTypeScriptAction($result->missing, Button::class);

        if ($docComment) {
            $docblock = $factory->create($docComment, new Context($class->getNamespaceName()));
            /** @var \phpDocumentor\Reflection\DocBlock\Tags\Property[] $tags */
            $tags           = $docblock->getTagsByName('property');
            foreach ($tags as $tag) {
                $name = $tag->getVariableName();
                if ($this->shouldIgnore($name)) {
                    continue;
                }
                $type        = $typeTranspiler->execute($tag->getType());
                $description = $tag->getDescription();
                if ($description) {
                    $description = $description->getBodyTemplate();
                }
                $result->properties[ $name ] = compact('type', 'name', 'description');
            }
        }

        foreach ($class->getProperties() as $property) {
            $name = $property->getName();
            if ($this->shouldIgnore($name)) {
                continue;
            }
            $docComment = $property->getDocComment();
            if ( ! $docComment) {
                continue;
            }
            $docblock = $factory->create($docComment);
            if ($docblock->hasTag('var')) {
                $tag         = $docblock->getTagsByName('var')[ 0 ];
                $type        = $typeTranspiler->execute($tag->getType());
                $description = $tag->getDescription();
                if ($description) {
                    $description = $description->getBodyTemplate();
                }
                $result->properties[ $name ] = compact('type', 'name', 'description');
            }
        }

        return $result;
    }

    public function setIntend($intend)
    {
        $this->intend = $intend;
        return $this;
    }

    public function setPropertiesRequired($propertiesRequired)
    {
        $this->propertiesRequired = $propertiesRequired;
        return $this;
    }

    public function ignoreProperties(array $ignoreProperties)
    {
        $this->ignoreProperties = $ignoreProperties;
        return $this;
    }

    protected function shouldIgnore($name)
    {
        return in_array($name, $this->ignoreProperties, true);
    }
}
