<?php

namespace Source\Csv;

class Maker
{
    private $csv;

    private $header;

    private $filePath;

    private const PATH = "/base/export/";

    private const SEPARATOR = ";";

    public function __construct(string $fileName)
    {
        $this->filePath = getenv("APP_ROOT") . self::PATH . $fileName;
        if (file_exists($this->filePath)) {
            $this->filePath = getenv("APP_ROOT") .self::PATH . $fileName . uniqid("_") . ".csv";
        }
        $this->csv = fopen($this->filePath, "w+");
    }

    public function write(array $data): void
    {
        if (!$this->hasHeader()) {
            $this->setHeaders(array_keys($data));
        }

        foreach ($data as $header => $item) {
            if (!$this->hasHeader($header)) {
                $this->addHeader($header);
            }
        }
        $build = [];
        foreach ($this->getHeaders() as $header) {
            $build[$header] = $data[$header] ?? "";
        }
        fputcsv($this->csv, $build, self::SEPARATOR);
    }

    public function hasHeader($header = null)
    {
        if (!is_null($header)) {
            return array_search($header, $this->header) !== false;
        }
        return isset($this->header);
    }

    public function setHeaders(array $header)
    {
        $this->header = $header;
    }

    public function addHeader(string $header)
    {
        $this->header[] = $header;
    }

    public function getHeaders()
    {
        return $this->header;
    }

    public function finish()
    {
        fclose($this->csv);
        $data = file_get_contents($this->filePath);
        file_put_contents(
            $this->filePath,
            implode(
                self::SEPARATOR,
                $this->getHeaders() ?? []
            ) . "\n{$data}"
        );
    }
}
