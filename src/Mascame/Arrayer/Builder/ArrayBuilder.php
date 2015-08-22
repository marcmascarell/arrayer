<?php

namespace Mascame\Arrayer\Builder;


class ArrayBuilder extends AbstractBuilder {

    /**
     * @var array
     */
    protected $defaultOptions = [
        'oldSyntax' => false,
        'minify' => false,
        'startWithScript' => true,
        'initialStatement' => 'return ',
    ];

    /**
     * @return string
     */
    public function getContent() {
        $content = var_export($this->array, true) . $this->end();

        if (! $this->options['oldSyntax']) $content = $this->applyNewSyntax($content);

        if ($this->options['minify']) $content = $this->applyMinification($content);

        if ($this->options['startWithScript']) $this->content = $this->start();

        if ($this->options['initialStatement']) $this->content .= $this->options['initialStatement'];

        return $this->content . $content;
    }

    /**
     * @return $this
     */
    public function oldSyntax() {
        $this->options['oldSyntax'] = true;

        return $this;
    }

    /**
     * @param $content
     * @return mixed
     */
    protected function applyNewSyntax($content) {
        return preg_replace(
            [
                "/array \\($/m",
                "/\\),$/m",
                "/\\);$/m",
            ],
            [
                "[",
                "],",
                "];",
            ],
            $content
        );
    }

    /**
     * @param $content
     * @return mixed
     */
    protected function applyMinification($content) {
        $content = preg_replace([
                "/\\n^\\s+\\[/m",
                "/\\n^\\s+\\],/m",
                "/\\n^\\];/m",

                "/\\n^\\s+array \\(/m",
                "/\\n^\\s+\\),/m",
                "/\\n^\\);/m",

                "/\\n^\\s+\\'/m",
                "/\\n^\\s+(\\d) =>\\s/m",
            ],
            [
                "[",
                "],",
                "];",

                // old syntax
                "array(",
                "),",
                ");",

                "'",
                "$1=>",
            ],
           $content
        );

        $content = str_replace("' => '", "'=>'", $content);
        $content = str_replace("' => [", "'=>[", $content);
        $content = str_replace("' => array(", "'=>array(", $content);

        return $content;
    }

    /**
     * @return string
     */
    protected function end()
    {
        return ';';
    }

    /**
     * @return string
     */
    protected function start()
    {
        return '<?php' . PHP_EOL . PHP_EOL;
    }
}
