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
        $data = $this->normalizeIcon($data);
        $data = $this->normalizeTitle($data);
        $data = $this->normalizeTooltip($data);
        $data = $this->normalizeAttributes($data);

        if ($this->normalizers) {

            $data = $this->runNormalizers($data);
        }

        return $data;
    }

    /**
     * If a URL is present but not absolute
     * then we need to make it so.
     *
     * @param array $data
     */
    protected function normalizeUrl(array $data)
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
    protected function normalizeHref(array $data)
    {
        if (isset($data['attributes']['href'])) {

            if (!starts_with($data['attributes']['href'], 'http')) {

                $data['attributes']['href'] = url($data['attributes']['href']);
            }
        }

        return $data;
    }

    /**
     * Normalize the icon.
     *
     * @param array $data
     * @return array
     */
    protected function normalizeIcon(array $data)
    {
        if (isset($data['icon'])) {

            $data['icon'] = '<i class="' . $data['icon'] . '"></i>';
        }

        return $data;
    }

    /**
     * Normalize the title.
     *
     * @param array $data
     * @return array
     */
    protected function normalizeTitle(array $data)
    {
        if (isset($data['title'])) {

            $data['title'] = trans($data['title']);
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
    protected function normalizeTooltip(array $data)
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
    protected function normalizeAttributes(array $data)
    {
        if (isset($data['attributes'])) {

            $data['attributes'] = $this->cleanAttributes($data['attributes']);

            $data['attributes'] = attributes_string($data['attributes']);
        }

        return $data;
    }

    /**
     * Clean invalid attributes.
     *
     * @param $attributes
     * @return mixed
     */
    protected function cleanAttributes($attributes)
    {
        // Only strings can be an attribute.
        foreach ($attributes as $attribute => $value) {

            if (!is_string($value)) {

                unset($attributes[$attribute]);
            }
        }

        return $attributes;
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
     * @return array
     */
    protected function runNormalizers(array $data)
    {
        $normalized = [];

        foreach ($data as $key => $value) {

            foreach ($this->normalizers as $normalizer) {

                $normalized[$key] = $normalizer($value);
            }
        }

        return $normalized;
    }
}
 