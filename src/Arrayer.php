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
    protected $arrayDot = [];

    /**
     * @param array $array
     */
    public function __construct(array $array) {
        $this->array = $array;

        $this->arrayDot = $this->convertToArrayDot($this->array);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key) {
        return isset($this->arrayDot[$key]);
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null) {
        if ($this->has($key)) return $this->arrayDot[$key];

        return $default;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value) {
        $this->arrayDot[$key] = $value;

        /*
         * Possibly $value contains an array
         * so we need to ensure it gets converted to dot notation
         */
        $this->convertToArrayDot();

        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function delete($key) {
        unset($this->arrayDot[$key]);

        return $this;
    }

    /**
     * @return array
     */
    public function getArray() {
        return $this->revertArrayDot();
    }

    /**
     * @return array
     */
    public function getArrayDot() {
        return $this->arrayDot;
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
     * @return array
     */
    protected function revertArrayDot($arrayDot = []) {
        $array = (!empty($arrayDot)) ? $arrayDot : $this->arrayDot;

        $this->array = array();

        foreach ($array as $key => $value) {
            $this->arraySet($this->array, $key, $value);
        }

        return $this->array;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function convertToArrayDot($array = []) {
        if (! empty($array)) return $this->arrayDot($array);

        return $this->arrayDot = $this->arrayDot($this->arrayDot);
    }
}
