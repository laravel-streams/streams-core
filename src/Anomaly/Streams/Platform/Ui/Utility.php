<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/**
 * Class Utility
 *
 * This is the base utility class for the various UIs.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Utility
{

    use DispatchableTrait;

    /**
     * The request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The router object.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Create a new Utility instance.
     *
     * @param Request $request
     * @param Router  $router
     */
    function __construct(Request $request, Router $router)
    {
        $this->router  = $router;
        $this->request = $request;
    }

    /**
     * Return an array parsed into a string of attributes.
     *
     * @param array $attributes
     * @return string
     */
    public function attributes(array $attributes)
    {
        return implode(
            ' ',
            array_map(
                function ($v, $k) {

                    return $k . '=' . '"' . trans($v) . '"';
                },
                $attributes,
                array_keys($attributes)
            )
        );
    }

    /**
     * Evaluate closures in the entire data array.
     * Merge in entry data at this point as well if available.
     *
     * @param array          $data
     * @param array          $arguments
     * @param EntryInterface $entry
     * @return array|mixed|null
     */
    public function evaluate(array $data, array $arguments = [], EntryInterface $entry = null)
    {
        // Evaluate closures.
        $data = evaluate($data, $arguments);

        /**
         * In addition to evaluating we need
         * to merge in entry data as best we can.
         */
        foreach ($data as &$value) {

            if (is_string($value) and str_contains($value, '{')) {

                if ($entry) {

                    $value = merge($value, $entry->toArray());
                }
            }
        }

        return $data;
    }

    /**
     * Normalize and clean things up before returning.
     *
     * @param array $data
     * @return mixed
     */
    public function normalize(array $data)
    {
        /**
         * If a URL is present but not absolute
         * then we need to make it so.
         */
        if (isset($data['attributes']['url'])) {

            if (!starts_with($data['attributes']['url'], 'http')) {

                $data['attributes']['url'] = url($data['attributes']['url']);
            }

            $data['attributes']['href'] = $data['attributes']['url'];

            unset($data['attributes']['url']);
        }

        /**
         * Implode all the attributes left over
         * into an HTML attribute string.
         */
        if (isset($data['attributes'])) {

            $data['attributes'] = $this->attributes($data['attributes']);
        }

        return $data;
    }
}
 