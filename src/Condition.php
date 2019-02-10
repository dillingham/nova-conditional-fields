<?php

namespace NovaConditionalFields;

use Illuminate\Http\Resources\MergeValue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Controllers\ActionController;
use Laravel\Nova\Http\Controllers\UpdateFieldController;
use Laravel\Nova\Http\Controllers\ResourceShowController;
use Laravel\Nova\Http\Controllers\CreationFieldController;
use Laravel\Nova\Http\Controllers\ResourceIndexController;
use Laravel\Nova\Http\Controllers\ResourceStoreController;
use Laravel\Nova\Http\Controllers\ResourceUpdateController;

class Condition extends MergeValue
{
    /**
     * @var string
     */
    protected $attribute;

    /**
     * @var NovaRequest
     */
    protected $request;

    /**
     * @var bool
     */
    protected $hideOnIndex = true;

    /**
     * Condition constructor.
     *
     * @param  string $attribute
     */
    public function __construct($attribute)
    {
        parent::__construct([]);

        $this->attribute = $attribute;
        $this->request = resolve(NovaRequest::class);
    }

    /**
     * @return string
     */
    public function component()
    {
        return 'conditional';
    }

    /**
     * Prepare the given fields.
     *
     * @param  \Closure|array $fields
     * @param  string $condition
     * @param  mixed $value
     * @return array
     */
    protected function prepareFields($fields, $condition, $value = null)
    {
        $fields = collect(is_callable($fields) ? $fields() : $fields);
        $controller = $this->request->route()->controller;

        if (
            $controller instanceof CreationFieldController || $controller instanceof UpdateFieldController ||
            ($controller instanceof ActionController && $this->request->route()->getActionMethod() === 'index')
        ) {
            return $fields->each(function ($field) use ($condition, $value) {
                $field->withMeta([
                    'original_component' => $field->component(),
                    'component' => $this->component(),
                    'condition' => [$condition, $this->attribute, $value],
                ]);
            })->all();
        }

        if (
            $controller instanceof ResourceStoreController || $controller instanceof ResourceUpdateController ||
            ($controller instanceof ActionController && $this->request->route()->getActionMethod() === 'store')
        ) {
            $origin = $this->request->input($this->attribute);

            return $fields->filter(function () use ($value, $condition, $origin) {
                return $this->check($origin, $condition, $value);
            })->all();
        }

        if ($controller instanceof ResourceShowController) {
            $model = $this->request->findModelOrFail();
            $origin = $model->{$this->attribute};

            return $fields->filter(function () use ($value, $condition, $origin) {
                return $this->check($origin, $condition, $value);
            })->all();
        }

        if ($this->hideOnIndex && $controller instanceof ResourceIndexController) {
            return $fields->each->hideFromIndex()->all();
        }

        return $fields->all();
    }

    /**
     * Prevent hiding fields from the index view.
     *
     * @return $this
     */
    public function preventHidingOnIndex()
    {
        $this->hideOnIndex = false;

        return $this;
    }

    /**
     * @param  mixed $origin
     * @param  string $condition
     * @param  mixed $value
     * @return bool
     */
    protected function check($origin, $condition, $value)
    {
        switch ($condition) {
            case 'not':
                return $origin != $value;
            default:
                return $origin == $value;
        }
    }

    /**
     * @param  mixed $value
     * @param  \Closure|array $fields
     * @return $this
     */
    public function fieldsWhen($value, $fields)
    {
        $this->data = array_merge($this->data, $this->prepareFields($fields, 'equal', $value));

        return $this;
    }

    /**
     * @param  mixed $value
     * @param  \Closure|array $fields
     * @return $this
     */
    public function fieldsWhenNot($value, $fields)
    {
        $this->data = array_merge($this->data, $this->prepareFields($fields, 'not', $value));

        return $this;
    }

    /**
     * @param  string $attribute
     *
     * @return \NovaConditionalFields\Condition
     */
    public static function make($attribute)
    {
        return new self($attribute);
    }
}
