<?php

namespace App\Entity\Collection;

use App\Contracts\ArrayAccessible;

abstract class Collection implements ArrayAccessible
{
    public function __construct(protected array $items)
    {
    }

    public function toArray(): array
    {
        return $this->accessIfIsArrayAccessible($this->getProperties());
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function empty(): bool
    {
        return empty($this->items);
    }

    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    public function last(): mixed
    {
        return $this->items[$this->count() - 1] ?? null;
    }

    private function accessIfIsArrayAccessible(mixed $items): mixed
    {   
        if(!is_array($items)){
            $items = [$items];
        }

        $data = [];
        foreach($items as $key => $item){
            $data[$key] = $item;
            if($item instanceof ArrayAccessible || is_array($item)){
                if(!is_array($item)){
                    $item = $item->toArray();
                }

                $data[$key] = $this->accessIfIsArrayAccessible($item);
            }
        }

        return $data;
        
    }

    private function getProperties(): array
    {   
       $data = [];
       $class = new \ReflectionClass($this);
       foreach($class->getProperties() as $property){
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($this);
       }

       return $data;
    }

}