<?php

namespace Mascame\Arrayer;


class Arrayer {

    /**
     * @var array
     */
    protected $array;

    /**
     * @var array
     */
    protected $arrayDot = array();

    /**
     * @param array $array
     */
    public function __construct(array $array) {
        $this->array = $array;

        $this->convertToArrayDot();
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null) {
        $result = $this->arrayGet($this->arrayDot, $key, $default);

        if (! $result) return $default;

        return $result;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $this->arraySet($this->array, $key, $value);

        $this->convertToArrayDot();

        return $this;
    }

    /**
     * @param $key
     */
    public function delete($key) {
        $this->getArrayDot();

        unset($this->arrayDot[$key]);

        $this->revertArrayDot();

        return $this;
    }

    /**
     * @param $array
     * @return string
     */
    public function append($array) {
        array_push($this->array, $array);

        $this->convertToArrayDot();

        return $this;
    }

    /**
     * @return array
     */
    public function getArray() {
        return $this->array;
    }

    /**
     * @return array
     */
    public function getArrayDot() {
        if (!empty($this->arrayDot)) return $this->arrayDot;

        return $this->convertToArrayDot();
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    protected function arrayGet($array, $key, $default = null)
    {
        if (function_exists('array_get')) return array_get($array, $key, $default = null);

        if (is_null($key)) return $array;

        if (isset($array[$key])) return $array[$key];

        foreach (explode('.', $key) as $segment)
        {
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
            {
                return ($default instanceof \Closure)  ? $default() : $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * From Laravel framework
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    protected function arraySet(&$array, $key, $value) {
        if (function_exists('array_set')) return array_set($array, $key, $value);

        if (is_null($key)) return $array = $value;

        $keys = explode('.', $key);

        while (count($keys) > 1)
        {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if ( ! isset($array[$key]) || ! is_array($array[$key]))
            {
                $array[$key] = array();
            }

            $array =& $array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     * From Laravel framework
     *
     * @param  array   $array
     * @param  string  $prepend
     * @return array
     */
    protected function arrayDot($array, $prepend = null) {
        if (function_exists('array_dot')) return array_dot($array);

        $results = array();

        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $results = array_merge($results, $this->arrayDot($value, $prepend.$key.'.'));
            }
            else
            {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }

    /**
     * @param array $arrayDot
     */
    protected function revertArrayDot($arrayDot = array()) {
        $array = (!empty($arrayDot)) ? $arrayDot : $this->arrayDot;

        $this->array = array();

        foreach ($array as $key => $value) {
            $this->arraySet($this->array, $key, $value);
        }
    }

    /**
     * @param array $array
     * @return array
     */
    protected function convertToArrayDot($array = array()) {
        if (! empty($array)) {
            return $this->arrayDot($array);
        }

        return $this->arrayDot = $this->arrayDot($this->array);
    }
}
