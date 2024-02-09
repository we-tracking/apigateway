<?php

namespace App\Input;

use App\Http\Request\RequestInterface;
use Validators\Collection\ResultCollection;

abstract class Input
{
    private ResultCollection $result;

    public function __construct(
        private RequestInterface $request
    ) {
        $this->result = validator($this->rules())->validate($request->all());
        $this->throwIfInvalid();
    }

    public abstract function rules(): array;

    public function throwAutomatic(): bool
    {
        return true;
    }

    public function result(): ResultCollection
    {
        return $this->result;
    }

    public function request(): RequestInterface
    {
        return $this->request;
    }

    public function throwIfInvalid(): void
    {
        if ($this->result->failed() && $this->throwAutomatic()) {
            $this->result->throwOnFirstError();
        }
    }
}

