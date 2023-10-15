<?php

namespace Source\Curl;

final class CurlResponse
{
    public function __construct(
        private array $headers = [],
        private array $curlInfo = [],
        private string $response = ""
    ) {
    }

    /**
     * @return object
     */
    public function object() : ?object
    {
        return json_decode($this->response);
    }

    /**
     * @return mixed
     */
    public function json($key = null): mixed
    {
        $data = json_decode($this->body(), true);
        if ($key) {
            return dot($key, $data);
        }
        return $data;
    }

    public function statusCode()
    {
        return $this->curlInfo['http_code'];
    }

    /**
     * @return string
     */
    public function body(): string
    {
        return $this->response;
    }

    /**
     * @return array|string
     */
    public function getHeaders(?string $header = null): array|string
    {
        if ($header) {
            return $this->headers[$header];
        }
        return $this->headers;
    }

    /**
     * @return array|string
     */
    public function getInfo(?string $info = null): array|string
    {
        if ($info) {
            return $this->curlInfo[$info];
        }
        return $this->curlInfo;
    }

    /**
     * #### Retorna true caso o response contenha a string informada
     * @return bool
     * @param string
     */
    public function contains(string $string): bool
    {
        return str_contains($this->response, $string);
    }

    /**
     * ### Efetua recorte da pagina
     */
    public function cut(string $param1, string $param2)
    {
        $response = explode($param1, $this->response)[1];
        if ($response) {
            $response = explode($param2, $response)[0];
            if ($response) {
                return new self($this->headers, $this->curlInfo, $response);
            }
        }

        return false;
    }


    public function getStatusCode()
    {
        return $this->getInfo('http_code');
    }

    public function view(string $view)
    {
        if ($this->contains('name="' . $view . '"')) {
            $viewState = explode('name="' .  $view . '"', $this->body())[1];
            $viewState = explode('value="', $viewState)[1];
            $viewState = explode('"', $viewState)[0];
            return $viewState;
        }

        if ($this->contains("|{$view}|")) {
            $viewState = explode("|{$view}|", $this->body())[1];
            $viewState = explode("|", $viewState)[0];
            return $viewState;
        }

        return false;
    }

    public function explode(...$values)
    {
        $body = $this->body();
        foreach ($values as $index => $value) {
            if (is_array($value)) {
                $body = explode($value[0], $body)[$value[1]];
                continue;
            }

            $body = explode($value, $body)[!($index % 2)] ?? null;
            if (!$body) {
                return null;
            }
        }

        return $body;
    }
}
