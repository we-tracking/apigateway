<?php

namespace App\ORM;

use App\ORM\Model;
class ModelCollection
{
    public function __construct(private array $models)
    {
    }

    public function map(callable $callable): self
    {
        return new self(array_map($callable, $this->models));
    }

    public function first(): ?Model
    {
        return $this->models[0] ?? null;
    }

    public function empty(): bool
    {
        return empty($this->models);
    }

    public function count(): int
    {
        return count($this->models);
    }

    /** @return array<Model> */
    public function getModels(): array
    {
        return $this->models;
    }

    public function toArray(): array
    {
        return array_map(fn($model) => $model->toArray(), $this->models);
    }

}
