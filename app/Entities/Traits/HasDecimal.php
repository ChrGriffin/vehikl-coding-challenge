<?php

namespace App\Entities\Traits;

trait HasDecimal
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->convertableDecimals)) {
            $value = $value <= 0 ? 0 : $value / 100;
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->convertableDecimals)) {
            $value = $value * 100;
        }

        return parent::setAttribute($key, $value);
    }
}