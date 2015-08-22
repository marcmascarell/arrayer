<?php

namespace Mascame\Arrayer\Builder;


abstract class AbstractBuilder implements BuilderInterface {

    /**
     * @var
     */
    protected $content;

    /**
     * @var array
     */
    protected $array = [];

    /**
     * @var array
     */
    protected $defaultOptions = [
        'minify' => false,
    ];

    /**
     * @param array $array
     * @param array $options
     */
    public function __construct(array $array, $options = []) {
        $this->array = $array;

        $this->options = array_merge($this->defaultOptions, $options);
    }

    /**
     * @return $this
     */
    public function minify() {
        $this->options['minify'] = true;

        return $this;
    }

}
