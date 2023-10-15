<?php

namespace Source\Exception;

use Source\Log\Log;
use Source\Enum\Http;
use Source\Console\Displayer;
use Source\Contracts\ExceptionHandlerInterface;
use Throwable;

class CommandHandler implements ExceptionHandlerInterface
{

    private Displayer $console;

    public function __construct(){
        $this->console =  resolve(Displayer::class);
    }

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
        if(!$this->renderMapped($error)){
            $this->console->error($error->getMessage());
        }
    }
    
    private function authentication(Throwable $errors ){

        $this->console->warning("NOT_AUTHORIZED");
        exit;
    }

    private function fatal(Throwable $errors ){

        $this->console->error($errors->getMessage());
        exit;
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
