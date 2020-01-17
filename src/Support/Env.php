<?php

namespace Anomaly\Streams\Platform\Support;

use Dotenv\Dotenv;

/**
 * Class Env
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Env
{

    /**
     * Load env variables. 
     */
    public static function load()
    {
        if (!is_file($file = base_path('.env'))) {
            return;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {

            // Check for # comments.
            if (!starts_with($line, '#')) {
                putenv($line);
            }
        }

        /**
         * Force the internal management to reload
         * and overload from the changes that may
         * have taken place.
         */
        $dotenv = Dotenv::create(base_path());
        $dotenv->overload();
    }

    /**
     * Return the .env variables.
     * 
     * @return array
     */
    public static function variables()
    {
        $data = [];

        $file = base_path('.env');

        if (!file_exists($file)) {
            return $data;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES) as $line) {

            // Check for # comments.
            if (starts_with($line, '#')) {
                $data[] = $line;
            } elseif ($operator = strpos($line, '=')) {
                $key   = substr($line, 0, $operator);
                $value = substr($line, $operator + 1);

                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Write a variable value.
     *
     * @param mixed $variable
     * @param mixed $value
     */
    public static function write($variable, $value)
    {
        $variables = Env::variables();
        $variable = strtoupper($variable);

        if (isset($variables[$variable])) {
            $contents = preg_replace("/{$variable}=.+/", "{$variable}=\"{$value}\"", file_get_contents($env = base_path('.env')));
        } else {
            $contents .= "\n{$variable}=\"{$value}\"";
        }

        file_put_contents($env, $contents);
    }

    /**
     * Write a variable value.
     *
     * @param mixed $data
     */
    public static function save(array $data)
    {
        $env = base_path('.env');

        $variables = Env::variables();

        foreach ($data as $key => $value) {

            $variable = strtoupper($key);

            if (isset($variables[$variable])) {
                $contents = preg_replace("/{$variable}=.+/", "{$variable}=\"{$value}\"", file_get_contents($env));
            } else {
                $contents .= "\n{$variable}=\"{$value}\"";
            }
        }

        file_put_contents($env, $contents);
    }
}
