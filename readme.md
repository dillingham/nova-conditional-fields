# Nova Conditional Fields
Conditionally display fields based on another field's value

### Install
```
composer require dillingham\nova-conditional-fields
```

### Usage
```
use NovaConditionalFields\Condition;
```
Example using a boolean field
```php
Boolean::make('Show Fields'),

Condition::make('Show Fields')
    ->fieldsWhen(true, [
        Text::make('Extra Setting 1'),
        Text::make('Extra Setting 2'),
        Text::make('Extra Setting 3'),
    ])
```
An example using select

```php
Select::make('Type')->options([
    'type-1' => 'Type 1',
    'type-2' => 'Type 2',
]),

Condition::make('Type')
    ->fieldsWhen('type-1', [
        Text::make('Setting 1'),
        Text::make('Setting 2'),
        Text::make('Setting 3'),
    ])->fieldsWhen('type-2', [
        Text::make('Setting 4'),
        Text::make('Setting 5'),
        Text::make('Setting 6'),
    ])
```

### Coming soon
-- BelongsTo support

-- fieldsWhenNot

-- fieldsWhenEmpty