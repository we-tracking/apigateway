<?php

use Source\Helpers\Render;
use Source\Validators\Rules;
use Source\Container\Container;
use Source\Validators\Validator;
use Source\Console\Features\Boot;

if (!function_exists("resolve")) {
    /**
     * Resolve dependencias de uma classe ou callback
     */
    function resolve(string|callable $id, array $params = []): mixed
    {
        return container()->make($id, $params);
    }
}

if (!function_exists("container")) {
    /**
     * Retorna uma instancia de Source\Container\Container
     * ou uma instancia resolvida 
     * 
     * @return Container|mixed
     */
    function container($abstract = null)
    {
        if ($abstract) {
            return resolve($abstract);
        }

        return Container::getInstance();
    }
}

if (!function_exists('pascalCase')) {
    /**
     * Formata string para PascalCase
     *
     * @param string $string
     * @return string
     */
    function pascalCase(string $string): string
    {
        if (preg_match("/[A-Z]*|[_-]/", $string)) {
            if (strtoupper($string) === $string) {
                $string = strtolower($string);
            }
            // $string = strtolower($string);
        }

        $string = str_replace(["_", "-"], " ", trim(strtolower(macroCase($string))));
        $string = ucwords($string);
        $string = str_replace(" ", "", $string);
        return $string;
    }
}

if (!function_exists('camelCase')) {
    /**
     * Formata string para PascalCase
     *
     * @param string $string
     * @return string
     */
    function camelCase(string $string): string
    {
        return lcfirst(pascalCase($string));
    }
}


if (!function_exists('snakeCase')) {
    /**
     * Formata string para snake_case
     *
     * @param string $string
     * @return string
     */
    function snakeCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}


if (!function_exists('macroCase')) {
    /**
     * Formata string para MACRO_CASE
     *
     * @param string $string
     * @return string
     */
    function macroCase(string $string): string
    {
        $string = str_replace(["-", " "], "_", $string);
        if (strtoupper($string) === $string) {
            $string = strtolower($string);
        }
        return strtoupper(strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string)));
    }
}

if (!function_exists('resource')) {
    /**
     * Retorna um recurso
     *
     * @param ?string $string
     * @return mixed
     */
    function resource(?string $resource = null): mixed
    {

        $baseNamespace = \Source\Resources::class;
        $baseFilePath = __DIR__;

        if (!$resource) {
            return  $baseFilePath;
        }

        $resourceClass = array_map(fn ($item) => ucfirst($item),  explode("/", $resource));
        $resourceClass = $baseNamespace . "\\" . implode("\\", $resourceClass);
        if (class_exists($resourceClass)) {
            return resolve($resourceClass);
        }

        $resource = $baseFilePath . "/" . $resource;
        if (is_dir($resource)) {
            return glob($resource . "/*.php");
        }
        if (file_exists($resource) || file_exists($resource =  $resource . '.php')) {
            if (endsWith(".php", $resource)) {
                return require $resource;
            }
            return file_get_contents($resource);
        }

        return false;
    }
}

if (!function_exists('dd')) {
    /**
     * Printa uma variavel e encerra a execucao
     *
     * @param mixed $var
     * @return void
     */
    function dd(...$var): void
    {
        foreach ($var as $item) {
            echo "<pre>";
            var_dump($item);
            echo "</pre>";
        }
        die();
    }
}


if (!function_exists('dot')) {
    /**
     * navega por um array atravez de dotNotation
     *
     * @param mixed $var
     * @return mixed
     */
    function dot(string $search, array|object $array): mixed
    {
        if (array_key_exists($search, $array)) {
            return $array[$search];
        }
        if (!str_contains($search, '.')) {
            return $array[$search] ?? null;
        }

        foreach (explode('.', $search) as $segment) {
            if (is_object($array) and isset($array->{$segment})) {
                $array = $array->{$segment};
                continue;
            }
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return null;
            }
        }

        return $array;
    }
}

if (!function_exists('beginsWith')) {
    /**
     * compara se uma string comeca com outra
     *
     * @return bool
     */
    function beginsWith(string $search, string $string): mixed
    {
        return 0 === strncmp($search, $string, \strlen($search));
    }
}

if (!function_exists("endsWith")) {
    /**
     * compara se uma string termina com outra
     *
     * @return bool
     */
    function endsWith(string $search, string $string): mixed
    {
        return substr($string, -strlen($search)) === $search;
    }
}

if (!function_exists("mask")) {
    /**
     * aplica uma mascara a uma string
     * 
     * @return string
     */
    function mask(string $string, string $pattern = "#")
    {

        $pattern = str_replace("#", "%s", $pattern);
        return sprintf($pattern, ...str_split($string));
    }
}

if (!function_exists("validator")) {
    /**
     * aplica uma mascara a uma string
     * 
     * @return Validator|Rules
     */
    function validator(array $rules = []): Rules|Validator
    {
        $validator  = resolve(Validator::class);
        if (count($rules) != 0) {
            return new Rules($validator, $rules);
        }

        return $validator;
    }
}

if (!function_exists("cache")) {
    /**
     * Retorna o valor de uma variavel de ambiente
     * 
     * @return mixed
     */
    function cache(string $cache): mixed
    {
        $cache = explode(".", $cache);
        $name = array_shift($cache);
        $path = implode(".", $cache);

        $baseFilePath = realpath(".") . "/storage/cache/{$name}.php";
        if (!file_exists($baseFilePath)) {
            return false;
        }

        if (!empty($path)) {
            return dot($path, require $baseFilePath);
        }


        return require $baseFilePath;
    }
}

if (!function_exists("render")) {
    /**
     * retorna uma instancia de renderizaçao
     * 
     * @return mixed
     */
    function render($options = []): Render
    {
        return new Render($options);
    }
}


if (!function_exists("init")) {
    /**
     * @return bool
     */
    function init(): bool
    {      
        resolve(Boot::class)->dispatch();
        return true;
    }
}


if (!function_exists("filterKeys")) {
    /**
     * filtra um array associativo por chaves
     * @todo arrumar essa redundancia
     * 
     * @return array
     */
    function filterKeys(array|object $array, array $keys): array
    {   
        if (!array_is_list((array)$array)) {
            return array_filter((array)$array, function ($key) use ($keys) {
                return in_array($key, $keys);
            }, ARRAY_FILTER_USE_KEY);
        }

        return array_map(function ($value) use ($keys) {
            return array_filter((array)$value, function ($key) use ($keys) {
                return in_array($key, $keys);
            }, ARRAY_FILTER_USE_KEY);
        }, $array);
    }
}
