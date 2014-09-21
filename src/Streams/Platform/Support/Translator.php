<?php namespace Streams\Platform\Support;

use Illuminate\Translation\Translator as BaseTranslator;

class Translator extends BaseTranslator
{
    /**
     * Get the translation for the given key.
     *
     * @param  string $key
     * @param  array  $replace
     * @param  string $locale
     * @return string
     */
    public function get($key, array $replace = [], $locale = null)
    {
        list($namespace, $group, $item) = $this->parseKey($key);

        $this->getAddon($namespace);

        return parent::get($key, $replace, $locale);
    }

    /**
     * Get the addon if a module namespace is detected.
     *
     * @param $namespace
     * @return bool|mixed
     */
    public function getAddon($namespace)
    {
        if (str_contains($namespace, '.')) {
            return \App::make('streams.' . $namespace);
        }

        return false;
    }
}
