<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Length
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Length
{

    /**
     * Units conversion array.
     *
     * @var array
     */
    protected $units = [
        'm'   => 1,
        'km'  => 1000,
        'dm'  => 0.1,
        'cm'  => 0.01,
        'mm'  => 0.001,
        'deg' => 111111,
        'in'  => 1 / 39.370079,
        'ft'  => 1 / 3.280840,
        'yd'  => 1 / 1.093613,
        'mi'  => 1 / 0.000621,
    ];

    /**
     * The length value we're working with.
     * This is always going to be meters.
     *
     * @var float|int
     */
    protected $length;

    /**
     * Create a new Length instance.
     *
     * @param float|int $length
     */
    public function __construct($length, $unit = null)
    {
        if (str_is('* *', strtolower($length)) && $parts = preg_split('/(?<=\d)\s+(?=\D+)/', $length)) {
            $length = array_get($parts, 0, 0);
            $unit   = array_get($parts, 1, 'n/a');
        }

        if (!$multiplier = array_get($this->units, strtolower($unit))) {
            $supported = implode(',', array_keys($this->units));
            throw new \Exception("Invalid unit [{$unit}] provided.\nSupported units are [{$supported}]");
        }

        $this->length = $length * $multiplier;
    }

    /**
     * Convert the value to a unit.
     *
     * @param $unit
     * @return float|int
     * @throws \Exception
     */
    public function to($unit)
    {
        if (!$multiplier = array_get($this->units, strtolower($unit))) {
            $supported = implode(',', array_keys($this->units));
            throw new \Exception("Invalid unit [{$unit}] provided.\nSupported units are [{$supported}]");
        }

        return $this->length * (1 / $multiplier);
    }

    /**
     * Return the length in meters.
     *
     * @return float|int
     */
    public function meters()
    {
        return $this->to('m');
    }

    /**
     * Return the length in kilometers.
     *
     * @return float|int
     */
    public function kilometers()
    {
        return $this->to('km');
    }

    /**
     * Return the length in decimeters.
     *
     * @return float|int
     */
    public function decimeters()
    {
        return $this->to('dm');
    }

    /**
     * Return the length in centimeters.
     *
     * @return float|int
     */
    public function centimeters()
    {
        return $this->to('cm');
    }

    /**
     * Return the length in millimeters.
     *
     * @return float|int
     */
    public function millimeters()
    {
        return $this->to('mm');
    }

    /**
     * Return the length in degrees.
     *
     * @return float|int
     */
    public function degrees()
    {
        return $this->to('deg');
    }

    /**
     * Return the length in inches.
     *
     * @return float|int
     */
    public function inches()
    {
        return $this->to('in');
    }

    /**
     * Return the length in feet.
     *
     * @return float|int
     */
    public function feet()
    {
        return $this->to('ft');
    }

    /**
     * Return the length in yards.
     *
     * @return float|int
     */
    public function yards()
    {
        return $this->to('yd');
    }

    /**
     * Return the length in miles.
     *
     * @return float|int
     */
    public function miles()
    {
        return $this->to('mi');
    }

}
