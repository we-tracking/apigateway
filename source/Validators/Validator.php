<?php

namespace Source\Validators;

use Source\Request\Request;
use Source\Helpers\ClassLoader;
use Source\Validators\handlers;

final class Validator
{

    private array $rules = [];

    private array $activeRules = [];

    public function __construct()
    {
        $this->boot();
    }

    public function __call($name, $values)
    {
        $name = pascalCase($name);
        if ($this->has($name)) {
            $validator = $this->get($name);
            $validator["parameters"] = $values;
            $this->setActiveRules($validator);
            return $this;
        }

        throw new \Exception("Regra de validação não encontrada!");
    }

    public function validate(mixed ...$values): Errors
    {
        $errors = new Errors;
        foreach ($values as $value) {
            foreach ($this->activeRules as $key => $rules) {
                $handler = $rules["execution"]($rules["parameters"])->validate($value);
                if (!$handler) {
                    $errors->add([
                        "message" => $rules["message"],
                        "name" => $rules["name"],
                        "field" => $key
                    ]);
                }
            };
        }
        $this->refresh();
        return $errors;
    }

    private function get(string $rule)
    {
        return $this->rules[$rule];
    }

    public function has(string $rule)
    {
        return array_key_exists($rule, $this->rules);
    }

    private function setActiveRules(array $rules)
    {
        $this->activeRules[] = $rules;
    }

    private function refresh()
    {
        $this->activeRules = [];
    }

    private function boot()
    {
        $validation = new Validations;
        if (!$validation->isBooted()) {
            $validation->boot();
        }

        $this->rules = $validation->getHandlers();
    }
}
