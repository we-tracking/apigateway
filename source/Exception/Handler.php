<?php

namespace Source\Exception;

use Source\Log\Log;
use Source\Enum\Http;
use Source\Contracts\ExceptionHandlerInterface;

class Handler implements ExceptionHandlerInterface
{

    private $logs = [
        \PDOException::class => "critical",
        \Exception::class => "info",
        \Error::class => "critical"
    ];

    private $errorRender = [
        "fatal" => [
            \Error::class,
            \PDOException::class
        ],
        "authentication" => [
            \Firebase\JWT\BeforeValidException::class,
            \Firebase\JWT\ExpiredException::class,
            \Firebase\JWT\SignatureInvalidException::class
        ]
    ];

    public function render(\Throwable $error)
    {
        // $this->catch($error);
        $httpCode =  Http::tryFrom($error->getCode()) ?? Http::BAD_REQUEST;
        $this->httpResponseCode($httpCode->value);
        if (!$this->renderMapped($error)) {
            $this->httpResponse($error->getMessage(), $httpCode->value);
        }
    }

    public function fatal(\Throwable $error)
    {
        $this->httpResponseCode(Http::INTERNAL_SERVER_ERROR->value);
        $this->httpResponse($error->getMessage());
    }

    public function authentication(\Throwable $error)
    {
        $this->httpResponseCode(Http::UNAUTHORIZED->value);
        $this->httpResponse("Token de autenticacao invalido");
    }

    private function catch(\Throwable $error)
    {
        foreach ($this->logs as $exception => $log) {
            if ($error instanceof $exception) {
                $this->log($error, $log);
            }
        }
    }

    private function log(\throwable $error, string $log)
    {
        Log::$log(sprintf("[ %s ] %s", $error::class, $error->getMessage()));
    }

    private function httpResponseCode(int $code)
    {
        http_response_code($code);
    }

    private function httpResponse(string $message)
    {
        print(render()->json([
            "status" => false,
            "message" => $message
        ]));
    }

    private function renderMapped(\Throwable $error): bool
    {
        foreach ($this->errorRender as $function => $value) {
            foreach ($value as $exceptions) {
                if ($error instanceof $exceptions) {
                    $this->$function($error);
                    return true;
                }
            }
        }

        return false;
    }
}
