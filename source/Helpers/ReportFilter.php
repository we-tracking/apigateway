<?php

namespace Source\Helpers;

use ClanCats\Hydrahon\Query\Sql\Select;
use ClanCats\Hydrahon\Query\Sql\Func as Func;

class ReportFilter
{

    public function __construct(private array $options = [])
    {
    }

    public function getFiltered(Select $query): Select
    {
        foreach ($this->options as $key => $value) {
            if (beginsWith("*", $key)) {
                $query->{trim($key, "*")}(...$value);
            } else if (is_array($value)) {
                if ($value[0] && $value[1]) {
                    $query->where(new Func("date", $key), ">=", $value[0]);
                    $query->where(new Func("date", $key), "<=", $value[1]);
                } else if ($value[0]) {
                    $query->where(new Func("date", $key), "=", $value[0]);
                }
            } else  if ($value !== null && (beginsWith("%", $value) || endsWith("%", $value))) {
                if (empty(trim($value, "%"))) {
                    continue;
                }
                $query->where($key, "like", $value);
            } else if ($value != null) {
                $query->where($key, $value);
            }
        }

        return $query;
    }
}
