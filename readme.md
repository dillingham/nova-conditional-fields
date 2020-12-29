# Nova Conditional Fields

[![Latest Version on Github](https://img.shields.io/github/release/dillingham/nova-conditional-fields.svg?style=flat-square)](https://packagist.org/packages/dillingham/nova-conditional-fields)
[![Total Downloads](https://img.shields.io/packagist/dt/dillingham/nova-conditional-fields.svg?style=flat-square)](https://packagist.org/packages/dillingham/nova-conditional-fields) [![Twitter Follow](https://img.shields.io/twitter/follow/im_brian_d?color=%231da1f1&label=Twitter&logo=%231da1f1&logoColor=%231da1f1&style=flat-square)](https://twitter.com/im_brian_d)

Conditionally display fields based on another field's value

### Install
```
composer require dillingham/nova-conditional-fields
```

### Usage
```php
use NovaConditionalFields\Condition;
```
Example using a boolean field
```php
Boolean::make('Show Fields'),

Condition::make('Show Fields')
    ->when(true, [
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
    ])->when('type-2', [
        Text::make('Setting 4'),
        Text::make('Setting 5'),
        Text::make('Setting 6'),
    ])
```

### Coming soon
-- BelongsTo support

-- whenTrue

-- whenNot

-- whenEmpty

---

# Author

Hi 👋, Im Brian Dillingham, creator of this Nova package [and others](https://novapackages.com/collaborators/dillingham)

Hope you find it useful. Feel free to reach out with feedback.

Follow me on twitter: [@im_brian_d](https://twitter.com/im_brian_d) 
