<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use Intervention\Image\Constraint;

/**
 * Trait HasAlterations
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasAlterations
{

    /**
     * The image alterations.
     *
     * @var array
     */
    public $alterations = [];

    /**
     * Return if a method is an alteration
     * method for Intervention.
     *
     * @param string $method
     *
     * @return bool
     */
    public function isAlteration(string $method)
    {
        return in_array($method, [
            'blur',
            'brightness',
            'colorize',
            'resizeCanvas',
            'contrast',
            'copy',
            'crop',
            'fit',
            'flip',
            'gamma',
            'greyscale',
            'heighten',
            'insert',
            'interlace',
            'invert',
            'limitColors',
            'pixelate',
            'opacity',
            'resize',
            'rotate',
            'amount',
            'widen',
            'orientate',
            'text',
        ]);
    }

    /**
     * Get the alterations.
     *
     * @return array
     */
    public function getAlterations()
    {
        return $this->alterations;
    }

    /**
     * Set the alterations.
     *
     * @param  array $alterations
     * @return $this
     */
    public function setAlterations(array $alterations)
    {
        $this->alterations = $alterations;

        return $this;
    }

    /**
     * Add an alteration.
     *
     * @param  $method
     * @param  $arguments
     * @return $this
     */
    public function addAlteration($method, $arguments = [])
    {
        if ($method == 'resize') {
            $this->guessResizeArguments($arguments);
        }

        $this->alterations[$method] = $arguments;

        return $this;
    }

    /**
     * Return if alteration is applied.
     *
     * @param $method
     * @return bool
     */
    public function hasAlteration($method)
    {
        return array_key_exists($method, $this->getAlterations());
    }

    /**
     * Return if any alterations are applied.
     *
     * @param $method
     * @return bool
     */
    public function hasAlterations()
    {
        return ($this->alterations);
    }

    /**
     * Guess the resize callback value
     * from a boolean.
     *
     * @param array $arguments
     */
    private function guessResizeArguments(array &$arguments)
    {
        $arguments = array_pad($arguments, 3, null);

        if (end($arguments) instanceof \Closure) {
            return;
        }

        if (array_pop($arguments) !== false) {
            $arguments[] = function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            };
        }
    }
}
