<?php

namespace Source\Validators;

use Source\Helpers\ClassLoader;

class Validations
{

    private static array $handlers = [];

    private static bool $isBooted = false;

    public function isBooted()
    {
        return self::$isBooted;

    }

    public function getHandlers()
    {
        return self::$handlers;
    }

    public function boot()
    {
        $loader = new ClassLoader(Handlers::class, true);
        $class = $loader->load();
        $messages = resource("ValidationMessages");
        array_map(
            function ($class) use ($messages) {
                $breakNamespace = explode("\\", $class);
                $name = lcfirst(pascalCase(end($breakNamespace)));
                $ruleName = explode("\\", $class);
                self::$handlers[end($ruleName)] = [
                    "execution" => fn (array $parameters) => new $class(...$parameters),
                    "name" => $name,
                    "message" => dot($name, $messages)
                ];
            },
            $class
        );
        self::$isBooted = true;
    }
}
