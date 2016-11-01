<?php

namespace Mascame\Arrayer\Builder;

class JsonBuilder extends AbstractBuilder
{
    /**
     * @return string
     */
    public function getContent()
    {
        if ($this->options['minify']) {
            return $this->content = json_encode($this->array);
        }

        return $this->content = json_encode($this->array, JSON_PRETTY_PRINT);
    }
}
