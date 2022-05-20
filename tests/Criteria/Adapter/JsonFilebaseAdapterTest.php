<?php

namespace Streams\Core\Tests\Criteria\Adapter;

use Illuminate\Support\Facades\File;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Tests\Criteria\FilebaseCriteriaTest;

class JsonFilebaseAdapterTest extends FilebaseCriteriaTest
{
    
    protected function setUp():void
    {
        parent::setUp();

        Streams::extend('films', [
            'config' => [
                'source' => [
                    'format' => 'json',
                    'type' => 'filebase',
                    'path' => 'streams/data/films/json',
                ],
            ],
        ]);
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
        // This is for file adapters only.
        File::deleteDirectory(base_path('streams/data/films/' . Streams::make('films')->config('source.format', 'json')));
    }

}
