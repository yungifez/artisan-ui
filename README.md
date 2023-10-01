## Arrtisan UI

This package includes some useful blade and livewire components for your Laravel application.

It is still super early in development, so please don't use it in production.

In fact I wrote this readme a day after I started the project

## Installation

Coming soon...

## Usage

You can use like so 

```php

<x-artisan-ui::button label="Button" /> or
<x-artisan-ui::button>
    Button
</x-artisan-ui::button>
<x-artisan-ui::input label="Name" placeholder="name"/>
<x-artisan-ui::textarea label="" />

//add multiple to use the custom built multiple select
<x-artisan-ui::select label="">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
</x-artisan-ui::select>

<x-artisan-ui::toggle /> 
//which returns a 1 or 0

// the best part is, it still feels and works like normal html tags

// I call it HTML with super powers
```

The input components support old values and error messages

![image](https://github.com/yungifez/artisan-ui/assets/63137056/a39effd3-0966-4795-8455-a63ee324337a)

