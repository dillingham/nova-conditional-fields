<?php

namespace NovaConditionalFields;

class Condition
{
    public static $attribute = null;

    public static function for($attribute)
    {
        self::$attribute = $attribute;

        return new static;
    }

    public function when($value, $fields)
    {
        $this->conditions[$value] = $fields;

        return $this;
    }

    public function make()
    {
        return new ConditionPanel(self::$attribute, $this->conditions);
    }
}