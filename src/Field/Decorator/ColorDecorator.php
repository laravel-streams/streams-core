<?php

namespace Streams\Core\Field\Decorator;

use Streams\Core\Field\FieldDecorator;

class ColorDecorator extends FieldDecorator
{
    public $levels = [];

    public function output()
    {
        $format = $this->field->config('format', 'hex');

        return $this->{$format}();
    }

    public function hex()
    {
        $levels = $this->levels();

        $hex = "#";
        $hex .= str_pad(dechex($levels['red']), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($levels['green']), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($levels['blue']), 2, "0", STR_PAD_LEFT);

        return $hex;
    }

    public function code()
    {
        return ltrim($this->hex(), '#');
    }

    public function rgb()
    {
        $levels = $this->levels();

        return 'rgb(' . $levels['red'] . ', ' . $levels['green'] . ', ' . $levels['blue'] . ')';
    }

    public function rgba()
    {
        $levels = $this->levels();

        return 'rgba(' . $levels['red'] . ', ' . $levels['green'] . ', ' . $levels['blue'] . ', ' . $levels['alpha'] . ')';
    }

    public function red()
    {
        return $this->levels()['red'];
    }

    public function green()
    {
        return $this->levels()['green'];
    }

    public function blue()
    {
        return $this->levels()['blue'];
    }

    public function alpha()
    {
        return $this->levels()['alpha'];
    }

    public function levels()
    {
        if ($this->levels) {
            return $this->levels;
        }

        if (!$this->value) {
            return $this->levels = ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 0];
        }

        if (strpos($this->value, '#') === 0) {
            return $this->levels = $this->levelsFromHex($this->value);
        }

        if (strpos($this->value, 'rgb(') === 0) {
            return $this->levels = $this->levelsFromRgb($this->value);
        }

        if (strpos($this->value, 'rgba(') === 0) {
            return $this->levels = $this->levelsFromRgba($this->value);
        }

        throw new \Exception("Format for color [{$this->value}] could not be determined.");
    }

    protected function levelsFromHex($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $red   = hexdec($hex[0] . $hex[0]);
            $green = hexdec($hex[1] . $hex[1]);
            $blue  = hexdec($hex[2] . $hex[2]);
        } else {
            $red   = hexdec($hex[0] . $hex[1]);
            $green = hexdec($hex[2] . $hex[3]);
            $blue  = hexdec($hex[4] . $hex[5]);
        }

        $alpha = 1;

        return compact('red', 'green', 'blue', 'alpha');
    }

    protected function levelsFromRgb($rgb)
    {
        $levels = explode(',', str_replace([' ', 'rgb(', 'rgba(', ')'], '', $rgb));

        $red   = (int) $levels[0];
        $green = (int) $levels[1];
        $blue  = (int) $levels[2];
        $alpha = 1;

        return compact('red', 'green', 'blue', 'alpha');
    }

    protected function levelsFromRgba($rgba)
    {
        $levels = explode(',', str_replace([' ', 'rgba(', ')'], '', $rgba));

        $red   = (int) $levels[0];
        $green = (int) $levels[1];
        $blue  = (int) $levels[2];
        $alpha = floatval($levels[3]);

        if ($alpha == round($alpha)) {
            $alpha = (int) $alpha;
        }

        return compact('red', 'green', 'blue', 'alpha');
    }
}
