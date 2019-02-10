<?php

namespace NovaConditionalFields;

use Laravel\Nova\Panel;

class ConditionPanel extends Panel
{
    protected function prepareFields($conditions)
    {
        foreach($conditions as $value => $fields) {
            foreach($fields as $field) {
                $field->withMeta([
                    'panel' => $this,
                    'panel_attribute' => $this->name,
                    'panel_value' => $value
                ]);

                $this->data[] = $field;
            }
        }

        return $this->data;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'component' => 'conditional',
            'showToolbar' => false,
        ];
    }
}