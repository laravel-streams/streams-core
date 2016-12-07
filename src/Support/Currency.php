<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Config\Repository;

/**
 * Class Currency
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Currency
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new Currency instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Return a formatted currency string.
     *
     * @param      $number
     * @param null $currency
     * @param array $options
     * @return string
     */
    public function format($number, $currency = null, array $options = [])
    {
        $currency = strtoupper($currency ?: $this->config->get('streams::currencies.default'));

        $direction = array_get(
            $options,
            'direction',
            $this->config->get('streams::currencies.supported.' . $currency . '.direction', 'ltr')
        );
        $separator = array_get(
            $options,
            'separator',
            $this->config->get('streams::currencies.supported.' . $currency . '.separator', ',')
        );
        $decimals  = array_get(
            $options,
            'decimals',
            $this->config->get('streams::currencies.supported.' . $currency . '.decimals', 2)
        );
        $point     = array_get(
            $options,
            'point',
            $this->config->get('streams::currencies.supported.' . $currency . '.point' . '.')
        );

        $prefix = null;
        $suffix = null;

        if (strtolower($direction) == 'ltr') {
            $prefix = $this->symbol($currency);
        } else {
            $suffix = $this->symbol($currency);
        }

        return $prefix . number_format(floor(($number * 100)) / 100, $decimals, $point, $separator) . $suffix;
    }

    /**
     * Normalize the currency value.
     *
     * @param      $number
     * @param null $currency
     * @param array $options
     * @return float
     */
    public function normalize($number, $currency = null, array $options = [])
    {
        $currency = strtoupper($currency ?: $this->config->get('streams::currencies.default'));

        $decimals = array_get(
            $options,
            'decimals',
            $this->config->get('streams::currencies.supported.' . $currency . '.decimals', 2)
        );
        $point    = array_get(
            $options,
            'point',
            $this->config->get('streams::currencies.supported.' . $currency . '.point' . '.')
        );

        return floatval(number_format(floor(($number * 100)) / 100, $decimals, $point, ''));
    }

    /**
     * Return the currency symbol.
     *
     * @param null $currency
     * @return string
     */
    public function symbol($currency = null)
    {
        if (!$currency) {
            $currency = $this->config->get('streams::currencies.default');
        }

        return $this->config->get('streams::currencies.supported.' . strtoupper($currency) . '.symbol');
    }
}
