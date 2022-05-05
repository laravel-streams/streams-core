<?php

namespace Streams\Core\Tests\Criteria\Adapter;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Tests\Criteria\CriteriaTest;

class DatabaseAdapterTest extends CriteriaTest
{

    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('films');

        Schema::create('films', function (Blueprint $table) {
            $table->id('episode_id');
            $table->dateTime('created')->nullable();
            $table->dateTime('edited')->nullable();
            $table->string('title')->nullable();
            $table->text('opening_crawl')->nullable();
            $table->string('director')->nullable();
            $table->string('producer')->nullable();
            $table->date('release_date')->nullable();
            $table->string('characters')->nullable();
            $table->string('starships')->nullable();
            $table->string('vehicles')->nullable();
            $table->string('planets')->nullable();
            $table->string('species')->nullable();
        });

        foreach (Streams::entries('films')->get() as $film) {

            $data = $film->toArray();

            $data['characters'] = json_encode($data['characters']);
            $data['starships'] = json_encode($data['starships']);
            $data['vehicles'] = json_encode($data['vehicles']);
            $data['planets'] = json_encode($data['planets']);
            $data['species'] = json_encode($data['species']);

            DB::table('films')->insert($data);
        }

        Streams::extend('films', [
            'config' => [
                'source' => [
                    'type' => 'database',
                    'table' => 'films',
                ],
            ],
        ]);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('films');

        parent::tearDown();
    }

    //public function test_it_returns_entries()
    //public function test_it_caches_results()
    //public function test_it_caches_when_stream_cache_is_enabled()
    //public function test_can_flush_cache()
    //public function test_cache_can_be_bypassed()
    //public function test_it_returns_the_first_result()
    //public function test_it_orders_results()
    //public function test_it_limits_results()
    //public function test_it_counts_results()
    //public function test_it_filters_results()
    //public function test_it_gets_and_sets_query_parameters()
    //public function test_it_paginates_results()
    //public function test_it_returns_new_instances()
    //public function test_it_creates_entries()
    //public function test_is_saves_entries()
    //public function test_it_deletes_entries()
    //public function test_it_truncates_entries()
    //public function test_can_chunk_results()
    //public function test_it_can_stop_chunking_results()
    //public function test_it_uses_stream_defined_criteria()
    //public function test_it_uses_stream_defined_adapter()
    //public function test_it_supports_macros()
    //public function test_it_throws_exception_for_bad_methods()

    protected function removeData()
    {
        DB::table('films')->truncate();
    }
}
