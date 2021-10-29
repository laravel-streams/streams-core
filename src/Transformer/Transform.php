<?php

namespace Streams\Core\Transformer;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTime;
use DateTimeImmutable;
use Spatie\LaravelTypeScriptTransformer\Transformers\SpatieStateTransformer;
use Spatie\TypeScriptTransformer\Collectors\DefaultCollector;
use Spatie\TypeScriptTransformer\Formatters\PrettierFormatter;
use Spatie\TypeScriptTransformer\TypeScriptTransformer;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfig;


class Transform
{

    public static function transform()
    {

        $config = TypeScriptTransformerConfig::create()
            ->autoDiscoverTypes(
                dirname(__DIR__),
                base_path('vendor/streams/ui/src'),
            )
            ->transformers([
                SpatieStateTransformer::class,
                ClassPropertyTagsTransformer::class,
            ])
            ->defaultTypeReplacements([
                DateTime::class          => 'string',
                DateTimeImmutable::class => 'string',
                CarbonImmutable::class   => 'string',
                Carbon::class            => 'string',
            ])
            ->collectors([
                DefaultCollector::class,
            ])
            ->formatter(PrettierFormatter::class)
            ->writer(TypeDefinitionWriter::class)
            ->outputFile(__DIR__ . '/../../resources/lib/types/streams.ts');

        TypeScriptTransformer::create($config)->transform();
    }

}
