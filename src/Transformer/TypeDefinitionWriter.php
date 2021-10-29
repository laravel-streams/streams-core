<?php

namespace Streams\Core\Transformer;

use Spatie\TypeScriptTransformer\Actions\ReplaceSymbolsInCollectionAction;
use Spatie\TypeScriptTransformer\Structures\TransformedType;
use Spatie\TypeScriptTransformer\Structures\TypesCollection;

class TypeDefinitionWriter extends \Spatie\TypeScriptTransformer\Writers\TypeDefinitionWriter
{
    public function format(TypesCollection $collection): string
    {
        (new ReplaceSymbolsInCollectionAction())->execute($collection);

        [$namespaces, $rootTypes] = $this->groupByNamespace($collection);

        $output = '';

        foreach ($namespaces as $namespace => $types) {
            asort($types);

            $output .= "export namespace {$namespace} {".PHP_EOL;

            $output .= join(PHP_EOL, array_map(
                fn (TransformedType $type) => "export interface {$type->name}  {$type->transformed};",
                $types
            ));


            $output .= PHP_EOL."}".PHP_EOL;
        }

        $output .= join(PHP_EOL, array_map(
            fn (TransformedType $type) => "export interface {$type->name}  {$type->transformed};",
            $rootTypes
        ));

        return $output;
    }

}
