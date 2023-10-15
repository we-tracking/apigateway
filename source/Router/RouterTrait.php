<?php

namespace Source\Router;

 
use \Source\Http\Response\ResponseInterface;

/**
 * Trait RouterTrait
 * @package CoffeeCode\Router
 */
trait RouterTrait
{

    public function parameter($key = null)
    {
        $parameters = $this->route["parameters"];
        if ($key) {
            return $parameters[$key] ?? null;
        }
        return $parameters;
    }

    public function current()
    {
        return $this->route;
    }
    /**
     * @param string $method
     * @param string $route
     * @param callable|string $handler
     * @param string|null $name
     * @param array|string|null $middleware
     */
    protected function addRoute(
        string $method,
        string $route,
        callable|string $handler,
        string $name = null,
        array|string $middleware = null
    ): void {
        $route = rtrim($route, "/");

        $removeGroupFromPath = $this->group ? str_replace($this->group, "", $this->path) : $this->path;
        $pathAssoc = trim($removeGroupFromPath, "/");
        $routeAssoc = trim($route, "/");

        preg_match_all("~\{\s* ([a-zA-Z_][a-zA-Z0-9_-]*) \}~x", $routeAssoc, $keys, PREG_SET_ORDER);
        $routeDiff = array_values(array_diff_assoc(explode("/", $pathAssoc), explode("/", $routeAssoc)));

        $parameters = [];
        $this->formSpoofing();
        $offset = 0;
        foreach ($keys as $key) {
            $this->data[$key[1]] = ($routeDiff[$offset++] ?? null);
            $parameters[$key[1]] = $this->data[$key[1]];
        }

        $route = (!$this->group ? $route : "/{$this->group}{$route}");
        $data = $this->data;
        $namespace = $this->namespace;
        $middleware = $middleware ?? (!empty($this->middleware[$this->group]) ? $this->middleware[$this->group] : null);
        $router = function () use ($method, $handler, $data, $route, $name, $namespace, $middleware, $parameters) {
            return [
                "route" => $route,
                "name" => $name,
                "method" => $method,
                "middlewares" => $middleware,
                "handler" => $this->handler($handler, $namespace),
                "action" => $this->action($handler),
                "data" => $data,
                "parameters" => $parameters,
            ];
        };

        $route = preg_replace('~{([^}]*)}~', "([^/]+)", $route);
        $this->routes[$method][$route] = $router();
    }

    /**
     * httpMethod form spoofing
     */
    protected function formSpoofing(): void
    {
        $post = json_decode(file_get_contents('php://input'), true);

        if (!empty($post['_method']) && in_array($post['_method'], ["PUT", "PATCH", "DELETE"])) {
            $this->httpMethod = $post['_method'];
            $this->data = $post;

            unset($this->data["_method"]);
            return;
        }

        if ($this->httpMethod == "POST") {
            $this->data = json_decode(file_get_contents('php://input'), true);

            unset($this->data["_method"]);
            return;
        }

        if (in_array($this->httpMethod, ["PUT", "PATCH", "DELETE"]) && !empty($_SERVER['CONTENT_LENGTH'])) {
            #modificado PUT
            // parse_str(file_get_contents('php://input', false, null, 0, $_SERVER['CONTENT_LENGTH']), $putPatch);
            $this->data = json_decode(file_get_contents('php://input'), true);

            unset($this->data["_method"]);
            return;
        }

        $this->data = [];
    }

    /**
     * @return bool
     */
    private function execute(): bool
    {
        if ($this->route) {
            if (!$middleware = $this->middleware()) {
                return false;
            }

            if (is_callable($this->route['handler'])) {
                call_user_func($this->route['handler'], ($this->route['data'] ?? []), $this);
                return true;
            }

            $controller = $this->route['handler'];
            $method = $this->route['action'];

            if (class_exists($controller)) {
                if (method_exists($controller, $method)) {

                    $request = new Request($middleware, $this->route['data'] ?? [], $this->query);
                    $this->app->bind(Request::class, fn () => $request);
                    $this->prepareHttpResponse($this->app->call("$controller@$method"));
                    return true;
                }

                $this->error = METHOD_NOT_ALLOWED;
                return false;
            }

            $this->error = BAD_REQUEST;
            return false;
        }

        $this->error = NOT_FOUND;
        return false;
    }

    /**
     * @return array|bool
     */
    private function middleware(): array|bool
    {
        if (empty($this->route["middlewares"])) {
            return true;
        }

        $middlewares = is_array(
            $this->route["middlewares"]
        ) ? $this->route["middlewares"] : [$this->route["middlewares"]];

        foreach ($middlewares as $middleware) {
            if (class_exists($middleware)) {
                $newMiddleware = new $middleware;
                if (method_exists($newMiddleware, "handle")) {
                    $middlewareResponse = $this->app->make($newMiddleware->handle(...));
                    if (!$middlewareResponse) {
                        return false;
                    }
                    $middlewareContent[$middleware] = $middlewareResponse;
                } else {
                    $this->error = METHOD_NOT_ALLOWED;
                    return false;
                }
            } else {
                $this->error = NOT_IMPLEMENTED;
                return false;
            }
        }

        return $middlewareContent ?? [];
    }

    /**
     * @param callable|string $handler
     * @param string|null $namespace
     * @return callable|string
     */
    private function handler(callable|string $handler, ?string $namespace): callable|string
    {
        return (!is_string($handler) ? $handler : "{$namespace}\\" . explode($this->separator, $handler)[0]);
    }

    /**
     * @param callable|string $handler
     * @return string|null
     */
    private function action(callable|string $handler): ?string
    {
        return (!is_string($handler) ?: (explode($this->separator, $handler)[1] ?? null));
    }

    /**
     * @param array $route_item
     * @param array|null $data
     * @return string|null
     */
    private function treat(array $route_item, array $data = null): ?string
    {
        $route = $route_item["route"];
        if (!empty($data)) {
            $arguments = [];
            $params = [];
            foreach ($data as $key => $value) {
                if (!strstr($route, "{{$key}}")) {
                    $params[$key] = $value;
                }
                $arguments["{{$key}}"] = $value;
            }
            $route = $this->process($route, $arguments, $params);
        }

        return "{$this->projectUrl}{$route}";
    }

    /**
     * @param string $route
     * @param array $arguments
     * @param array|null $params
     * @return string
     */
    private function process(string $route, array $arguments, array $params = null): string
    {
        $params = (!empty($params) ? "?" . http_build_query($params) : null);
        return str_replace(array_keys($arguments), array_values($arguments), $route) . "{$params}";
    }

    private function prepareHttpResponse(mixed $response, int $code = 200): void
    {
        http_response_code($code);
        if (is_array($response) || is_object($response)) {
            print(render()->json(["status" => true] + $response));
            return;
        }

        if (is_null($response)) {
            return;
        }
    }
}
