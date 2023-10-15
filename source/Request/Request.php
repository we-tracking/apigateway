<?php

namespace Source\Request;

use Source\Request\Foundation\InputBag;
use Source\Request\Foundation\QueryBag;
use Source\Request\Foundation\ServerBag;

class Request
{

    private QueryBag $query;
    private InputBag $request;
    private $attributes;
    private $cookies;
    private $files;
    private ServerBag $server;
    private $content;

    private ?\Closure $routeResolver = null;

    private ?\Closure $userResolver = null;

    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {

        $this->query = new QueryBag($query);
        $this->request = new InputBag($request);
        $this->attributes = $attributes;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = new ServerBag($server);
        $this->content = $content;
        if (!empty($headers = $this->server->getHeaders())) {
            if (isset($headers["CONTENT_TYPE"]) && $headers["CONTENT_TYPE"] === "application/json") {
                $this->request = new InputBag(
                    json_decode(
                        mb_convert_encoding($this->content, 'UTF-8'),
                        true
                    ) ?? []
                );
            }
        }
    }

    /**
     * Cria uma nova instanca de Request a partir das variaveis globais
     * 
     */
    public static function creacteFromGlobals()
    {
        $request = new static(
            query: $_GET,
            request: $_POST,
            attributes: [],
            cookies: $_COOKIE,
            files: $_FILES,
            server: $_SERVER,
            content: file_get_contents("php://input")
        );

        return $request;
    }

    public function all()
    {
        if (!empty($this->route())) {
            $routeParameters = $this->route()->parameter();
        }
        return array_merge($this->inputs(), $this->query(), $routeParameters ?? []);
    }

    /**
     * Retrna todos os inputs ou o input especificado
     * 
     */
    public function inputs($key = null): mixed
    {
        if ($key) {
            return dot($key, $this->request->all());
        }
        return $this->request->all();
    }

    /**
     * Retorna os Headers da requisição
     * 
     */
    public function getHeaders()
    {
        return $this->server->getHeaders();
    }

    public function header($key)
    {

        return $this->server->getHeaders()[$key] ?? null;
    }

    /**
     * Retorna os query Params
     * 
     */
    public function query($key = null)
    {
        $all = $this->query->all();
        if ($key) {
            return $all[$key] ?? null;
        }
        return $all;
    }

    public function setRouteResolver(\Closure $route): self
    {
        $this->routeResolver = $route;
        return $this;
    }

    public function getRouteResolver(): \Closure
    {
        return $this->routeResolver ?? function () {
        };
    }

    public function setUserResolver(\Closure $user): self
    {
        $this->userResolver = $user;
        return $this;
    }

    public function getUserResolver(): \Closure
    {
        return $this->userResolver ?? function () {
        };
    }

    /**
     * Retorna o usuario logado
     */
    public function user(): ?User
    {
        return call_user_func($this->getUserResolver());
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * Retorna a rota ou um parametro da rota
     */
    public function route($param = null)
    {
        $route = call_user_func($this->getRouteResolver());
        if (!$param || !$route) {
            return $route;
        }
        return $route->parameter($param);
    }

    public function __get($key)
    {
        return $this->all()[$key] ?? $this->route($key) ?? null;
    }

    public function validate(array $rules)
    {
        return validator($rules)->validate($this->all());
    }

    public function has(string $key)
    {
        return dot($key, $this->all()) != null;
    }
}
