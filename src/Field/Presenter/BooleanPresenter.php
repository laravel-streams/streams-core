<?php

namespace Streams\Core\Field\Presenter;

use Streams\Core\Field\FieldPresenter;

class BooleanPresenter extends FieldPresenter
{

    /**
     * Return whether the value is true.
     *
     * @return bool
     */
    public function isTrue()
    {
        return $this->is(true);
    }

    /**
     * Return whether the value is false.
     *
     * @return bool
     */
    public function isFalse()
    {
        return $this->is(false);
    }

    /**
     * Return if the value is true / false.
     *
     * @param $test
     * @return bool
     */
    public function is($test)
    {
        return $this->value === filter_var($test, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Return the text value.
     *
     * @param  null $on
     * @param  null $off
     * @return string
     */
    public function text($on = null, $off = null)
    {
        if ($on && $this->value) {
            return $on;
        }

        if ($off && !$this->value) {
            return $off;
        }

        return trans($this->value ? 'ui::message.on' : 'ui::message.off');
    }
}
