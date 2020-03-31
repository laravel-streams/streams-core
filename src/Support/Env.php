<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

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
     * 
     * @param string $suffix    Used like `.env{$suffix}`
     */
    public static function load($suffix = null)
    {
        if (!is_file($file = App::environmentFilePath() . $suffix)) {
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
        //Dotenv::create(base_path())->overload();

        (new LoadConfiguration)->bootstrap(app());

        DB::purge(config('database.default'));

        DB::reconnect();
    }

    /**
     * Return the .env variables.
     * 
     * @param string $suffix    Used like `.env{$suffix}`
     * @return array
     */
    public static function variables($suffix = null)
    {
        $data = [];

        $file = App::environmentFilePath() . $suffix;

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
     * @param string $suffix    Used like `.env{$suffix}`
     */
    public static function write($variable, $value = null, $suffix = null)
    {
        $variables = self::variables($suffix);
        $variable = strtoupper($variable);

        if (str_contains($value, ' ')) {
            $value = "\"{$value}\"";
        }

        $env = App::environmentFilePath() . $suffix;

        if (array_key_exists($variable, $variables)) {
            file_put_contents(
                $env,
                preg_replace("/{$variable}=(.+||$)/", "{$variable}=" . $value, file_get_contents($env))
            );
        } else {
            file_put_contents(
                $env,
                file_get_contents($env) . "\n{$variable}=" . $value
            );
        }
    }

    /**
     * Write a variable value.
     *
     * @param array $data
     * @param string $suffix    Used like `.env{$suffix}`
     */
    public static function save(array $data, $suffix = null)
    {
        foreach ($data as $key => $value) {
            self::write($key, $value, $suffix);
        }
    }

    /**
     * Generate the .env file.
     * 
     * @param string $suffix    Used like `.env{$suffix}`
     */
    public static function generate($suffix = null)
    {
        $base = App::environmentPath() . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($env = $base . $suffix)) {

            file_put_contents($env, file_get_contents($base . '.example'));

            config(['app.key' => $key = 'base64:' . base64_encode(
                random_bytes(config('app.cipher') === 'AES-128-CBC' ? 16 : 32)
            )]);

            Env::write('APP_KEY', $key, $suffix);

            return true;
        }

        return false;
    }
}
