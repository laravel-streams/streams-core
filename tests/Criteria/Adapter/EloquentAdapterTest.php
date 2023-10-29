<?php

namespace Streams\Core\Tests\Criteria\Adapter;

use Illuminate\Support\Facades\DB;
use Streams\Core\Tests\EloquentModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Tests\Criteria\CriteriaTest;
use Streams\Core\Criteria\Adapter\EloquentAdapter;

class EloquentAdapterTest extends CriteriaTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $data = Streams::entries('films')->get();

        Streams::extend('films', [
            'config' => [
                'source' => [
                    'type' => 'eloquent',
                    'model' => CustomExamplesEloquentModel::class,
                ],
            ],
        ]);

        Schema::dropIfExists('films');

        Schema::create('films', function (Blueprint $table) {
            $table->id('episode_id');
            $table->dateTime('created');
            $table->dateTime('edited')->nullable();
            $table->string('title');
            $table->longText('opening_crawl');
            $table->string('director');
            $table->string('producer');
            $table->string('release_date');
            $table->json('characters');
            $table->json('planets');
            $table->json('starships');
            $table->json('vehicles');
            $table->json('species');
        });

        foreach ($data as $entry) {

            $entry = $entry->toArray();

            $entry['edited'] = (string) $entry['edited'];
            $entry['created'] = (string) $entry['created'];
            $entry['release_date'] = (string) $entry['release_date'];

            $entry['characters'] = json_encode($entry['characters']);
            $entry['starships'] = json_encode($entry['starships']);
            $entry['vehicles'] = json_encode($entry['vehicles']);
            $entry['species'] = json_encode($entry['species']);
            $entry['planets'] = json_encode($entry['planets']);

            DB::table('films')->insert($entry);
        }
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('films');

        parent::tearDown();
    }

    public function test_it_uses_stream_defined_adapter()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'source' => [
                    'type' => 'eloquent',
                    'adapter' => CustomExamplesEloquentAdapter::class,
                ],
            ],
        ]);

        $entry = $stream->entries()->testMethod()->first();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }

    protected function removeData()
    {
        DB::table('films')->truncate();
    }
}

class CustomExamplesEloquentAdapter extends EloquentAdapter
{
    public function testMethod()
    {
        return $this->orderBy('title', 'DESC');
    }
}

class CustomExamplesEloquentModel extends EloquentModel
{
    public $timestamps = false;

    protected $table = 'films';
}
