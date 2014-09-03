<?php namespace Streams\Core\Helper;

class StreamsHelper
{
    /**
     * Get a cache key from anything passed in at all.
     *
     * @param $payload
     * @return string
     */
    public function value($value, $arguments = null, $recursive = false)
    {
        if ($value instanceof \Closure) {
            try {
                if ($recursive) {
                    return $this->value(call_user_func_array($value, $arguments), $arguments, $recursive);
                } else {
                    return call_user_func_array($value, $arguments);
                }
            } catch (\Exception $e) {
                return null;
            }
        } elseif (is_array($value)) {
            foreach ($value as &$val) {
                $val = $this->value($val, $arguments, $recursive);
            }
        }

        return $value;
    }
}
