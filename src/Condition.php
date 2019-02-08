<?php

namespace NovaConditionalFields;

use Laravel\Nova\Fields\Field;

class Condition extends Field
{
    public $conditions = [];

    public $showOnIndex = false;

    public $component = 'conditional';

    public function resolve($resource, $attribute = null)
    {
        $this->withMeta([
            'conditional' => true,
            'parent' => $this->attribute,
            'conditions' => $this->conditions
        ]);
    }

    public function fieldsWhen($value, $fields)
    {
        $this->conditions[] = [
            'value' => $value,
            'fields' => $fields
        ];

        return $this;
    }
}