<?php

namespace Mascame\Arrayer;


class Arrayer {

    /**
     * @var
     */
    protected $content;

    /**
     * @var int
     */
    protected $indentation = 0;


    /**
     * @param array $values
     */
    public function __construct(array $values) {
        return $this->make($values);
    }

    /**
     * @return string
     */
    public function getContent() {
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

        return $this;
    }

    /**
     * @return string
     */
    protected function start()
    {
        $content = '<?php' . PHP_EOL . PHP_EOL;
        $content .= 'return array(' . PHP_EOL . PHP_EOL;

        return $content;
    }

    /**
     * @param $key
     * @return string
     */
    protected function keyStart($key)
    {
        return $this->getIndentationTabs() . $this->wrapElement($key) . ' => array(' . PHP_EOL;
    }

    /**
     * @return string
     */
    protected function keyEnd()
    {
        return $this->getIndentationTabs() . '),' . PHP_EOL . PHP_EOL;
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
                $content .= $this->getIndentationTabs(1) . $this->wrapElement($key) . ' => ' . $this->wrapElement($value) . ',' . PHP_EOL;
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
     * @param $array
     * @return string
     */
    public function append($array) {
        return $this->make($array);
    }
}
