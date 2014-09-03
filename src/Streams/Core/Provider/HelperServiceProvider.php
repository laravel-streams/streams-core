<?php namespace Streams\Core\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Core\Helper\CacheHelper;
use Streams\Core\Helper\EntryHelper;
use Streams\Core\Helper\StreamsHelper;
use Streams\Core\Helper\ArrayHelper;
use Streams\Core\Helper\StringHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerStreamsHelper();
        $this->registerEntryHelper();
        $this->registerCacheHelper();
        $this->registerArrayHelper();
        $this->registerStringHelper();
    }

    /**
     * Register the streams helper Facade.
     */
    protected function registerStreamsHelper()
    {
        $this->app->singleton(
            'streams.helper',
            function () {
                return new StreamsHelper();
            }
        );
    }

    /**
     * Register the entry helper Facade.
     */
    protected function registerEntryHelper()
    {
        $this->app->singleton(
            'entry.helper',
            function () {
                return new EntryHelper();
            }
        );
    }

    /**
     * Register the cache helper Facade.
     */
    protected function registerCacheHelper()
    {
        $this->app->singleton(
            'cache.helper',
            function () {
                return new CacheHelper();
            }
        );
    }

    /**
     * Register the array helper Facade.
     */
    protected function registerArrayHelper()
    {
        $this->app->singleton(
            'array.helper',
            function () {
                return new ArrayHelper();
            }
        );
    }

    /**
     * Register the string helper Facade.
     */
    protected function registerStringHelper()
    {
        $this->app->singleton(
            'string.helper',
            function () {
                return new StringHelper();
            }
        );
    }
}
