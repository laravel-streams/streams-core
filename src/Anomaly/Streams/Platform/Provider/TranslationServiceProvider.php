<?php namespace Anomaly\Streams\Platform\Provider;

class TranslationServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Setup translation services.
     */
    public function register()
    {
        $this->addStreamsLangPath();
    }

    /**
     * Add the "streams" lang path.
     */
    protected function addStreamsLangPath()
    {
        
    }
}
