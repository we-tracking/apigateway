<?php

namespace Source\Csv;

class Parser
{
    private $currentLine;

    private $numberLines;

    private $stream;

    private array $headers;

    public function __construct(
        private string $file, 
        private bool $hasHeader = true
    )
    {
        $this->numberLines = count(file($file));
        $this->stream = fopen($file, "r");

        if($this->hasHeader()){
            $this->headers = $this->handler();
        }
    }

    public function getCurrentStream()
    {
        while( $item = $this->handler() ) { 
            if($this->hasHeader()){
                $item = array_combine($this->headers, $item);
            }
            yield $item;
        }
    }

    public function getNumberLines()
    {
        return $this->numberLines;
    }

    public function hasHeader(): bool {
        return $this->hasHeader;
    }

    private function handler(){
        return fgetcsv($this->stream, null, ";");
    }
}
