<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Translation\Translator as BaseTranslator;

class Translator extends BaseTranslator
{

    public function get($key, array $replace = [], $locale = null)
    {
        list($namespace, $group, $item) = $this->parseKey($key);

        $this->getAddon($namespace);

        return parent::get($key, $replace, $locale);
    }

    public function getAddon($namespace)
    {
        if (str_contains($namespace, '.')) {
            return app('streams.' . $namespace);
        }

        return false;
    }
}
