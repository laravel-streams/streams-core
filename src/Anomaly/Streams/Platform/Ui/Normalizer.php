<?php namespace Anomaly\Streams\Platform\Ui;

/**
 * Class Normalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Normalizer
{

    /**
     * Normalizers to run.
     *
     * @var array
     */
    protected $normalizers = [];

    /**
     * Normalize and clean things up before returning.
     *
     * @param array $data
     * @return mixed
     */
    public function normalize(array $data)
    {
        $data = $this->normalizeUrl($data);
        $data = $this->normalizeHref($data);
        $data = $this->normalizeTooltip($data);
        $data = $this->normalizeAttributes($data);

        if ($this->normalizers) {

            $this->runNormalizers($data);
        }

        return $data;
    }

    /**
     * If a URL is present but not absolute
     * then we need to make it so.
     *
     * @param array $data
     */
    protected function normalizeUrl(array $data = [])
    {
        if (isset($data['attributes']['url'])) {

            if (!starts_with($data['attributes']['url'], 'http')) {

                $data['attributes']['url'] = url($data['attributes']['url']);
            }
        }

        return $data;
    }

    /**
     * If a HREF is present but not absolute
     * then we need to make it so.
     *
     * @param array $data
     */
    protected function normalizeHref(array $data = [])
    {
        if (isset($data['attributes']['href'])) {

            if (!starts_with($data['attributes']['href'], 'http')) {

                $data['attributes']['href'] = url($data['attributes']['href']);
            }
        }

        return $data;
    }

    /**
     * If the tooltip-{direction} attribute is set
     * automate Bootstrap tooltip data attributes.
     *
     * @param array $data
     * @return array
     */
    protected function normalizeTooltip(array $data = [])
    {
        $tooltip   = null;
        $placement = null;

        if (isset($data['attributes']['tooltip'])) {

            $placement = 'top';
            $tooltip   = $data['attributes']['tooltip'];
        } elseif (isset($data['attributes']['tooltip-left'])) {

            $placement = 'tooltip-left';
            $tooltip   = $data['attributes']['tooltip'];
        } elseif (isset($data['attributes']['tooltip-right'])) {

            $placement = 'right';
            $tooltip   = $data['attributes']['tooltip-right'];
        } elseif (isset($data['attributes']['tooltip-top'])) {

            $placement = 'top';
            $tooltip   = $data['attributes']['tooltip-top'];
        } elseif (isset($data['attributes']['tooltip-bottom'])) {

            $placement = 'bottom';
            $tooltip   = $data['attributes']['tooltip-bottom'];
        }

        if ($tooltip and $placement) {

            $data['attributes']['data-toggle']         = 'tooltip';
            $data['attributes']['data-placement']      = $placement;
            $data['attributes']['data-original-title'] = trans($tooltip);

            unset($data['attributes']['tooltip'], $data['attributes']['tooltip-' . $placement]);
        }

        return $data;
    }

    /**
     * Implode all the attributes left over
     * into an HTML attribute string.
     *
     * @param array $data
     * @return array
     */
    protected function normalizeAttributes(array $data = [])
    {
        if (isset($data['attributes'])) {

            $data['attributes'] = attributes_string($data['attributes']);
        }

        return $data;
    }

    /**
     * Add an normalizer.
     *
     * @param callable $callback
     * @return $this
     */
    public function addNormalizer(\Closure $callback)
    {
        $this->normalizers[] = $callback;

        return $this;
    }

    /**
     * Run the normalizers.
     *
     * @param array $data
     */
    protected function runNormalizers(array &$data)
    {
        foreach ($data as &$value) {

            foreach ($this->normalizers as $normalizer) {

                $value = $normalizer($value);
            }
        }
    }
}
 