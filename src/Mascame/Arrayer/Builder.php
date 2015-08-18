<?php

namespace Mascame\Arrayer;


class Builder {

    /**
     * @var
     */
    protected $content;

    /**
     * @var int
     */
    protected $indentation = 0;

    /**
     * @var \Mascame\Arrayer\Arrayer
     */
    protected $arrayer;


    /**
     * @var bool
     */
    protected $minified;


    /**
     * @param array $array
     */
    public function __construct(\Mascame\Arrayer\Arrayer $array, $minified = false) {
        $this->array = $array;
        $this->minified = $minified;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() {
        $this->make($this->array->getArray());

        return $this->start() . $this->content . $this->end();
    }


    /**
     * @param $values
     * @param null $key
     * @param string $indentation
     * @return $this
     */
    protected function make($values, $key = null, $indentation = 'initial')
    {
        if ($indentation == 'initial' && !$key) {
            $this->indentation = 0;
        } elseif ($key !== null) {
            $this->indentation++;
        }

        if ($key !== null) $this->content .= $this->keyStart($key);

        if (is_array($values)) {
            $this->content .= $this->add($values);
        } else {
            $this->content .= $values;
        }

        if ($key !== null) $this->content .= $this->keyEnd();

        if ($indentation != 'initial' && $key !== null) {
            $this->indentation--;
        }

        return $this->content;
    }

    /**
     * @param $array
     * @return string
     */
    protected function add($array)
    {
        $content = '';

        foreach ($array as $key => $value) {

            if (!is_array($value)) {
                $content .= $this->getIndentationTabs(1)
                        . $this->wrapElement($key)
                        . $this->keyValueSeparator()
                        . $this->wrapElement($value) . ','
                        . $this->addSeparation(null);
            } else {
                $this->make($value, $key, 'indent');
            }

        }

        return $content;
    }

    /**
     * @param int $plus
     * @return string
     */
    protected function getIndentationTabs($plus = 0) {
        if ($this->minified) return null;

        return str_repeat("\t", $this->indentation + $plus);
    }

    /**
     * @param $string
     * @return string
     */
    private function wrapElement($string) {
        return '"' . addslashes($string) . '"';
    }

    /**
     * @return string
     */
    protected function end()
    {
        return ');';
    }

    /**
     * @return string
     */
    protected function start()
    {
        $content = '<?php' . $this->doubleSeparation();
        $content .= 'return array(' . $this->doubleSeparation(null);

        return $content;
    }

    /**
     * @param $key
     * @return string
     */
    protected function keyStart($key)
    {
        return $this->getIndentationTabs()
            . $this->wrapElement($key)
            . $this->customSeparation('=>array(', ' => array(')
            . $this->addSeparation(null);
    }

    /**
     * @return string
     */
    protected function keyEnd()
    {
        return $this->getIndentationTabs() . '),' . $this->doubleSeparation(null);
    }

    /**
     * @param string $separator
     * @return string
     */
    protected function addSeparation($separator = ' ') {
        return ($this->minified) ? $separator : PHP_EOL;
    }

    /**
     * @param string $separator
     * @return string
     */
    protected function doubleSeparation($separator = ' ') {
        return ($this->minified) ? $separator : $this->addSeparation() . $this->addSeparation();
    }

    /**
     * @param $minified
     * @param $normal
     */
    protected function customSeparation($minified, $normal) {
        return ($this->minified) ? $minified : $normal;
    }

    /**
     * @return string
     */
    protected function keyValueSeparator() {
        return ($this->minified) ? '=>' : ' => ';
    }
}
