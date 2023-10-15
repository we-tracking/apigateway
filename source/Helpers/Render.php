<?php

namespace Source\Helpers;

class Render
{
    public function __construct(private array $options = [])
    {
    }

    public function db(array|object $data)
    {
        if (!is_array((array)$data)) {
            throw new \RuntimeException("A renderizaçao de dados do BD so pode ser feita com arrays");
        }
        $data =  $this->keysToCamelCase($data);

        if (isset($this->options["index"])) {
            $data = array_slice($data, $this->options["index"] - 1, $this->options["limit"] ?? null);
        }

        return $data;
    }

    private function keysToCamelCase(array|object $data)
    {
        $converted = [];
        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $converted[$key] = $this->keysToCamelCase($value);
                continue;
            }

            $converted[camelCase($key)] = $value;
        }

        return $converted;
    }

    public function json(array|object $data  = [])
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
