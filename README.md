## Arrtisan UI

This package includes some useful blade and livewire components for your Laravel application.

It is still super early in development, so please don't use it in production.

In fact I wrote this readme a day after I started the project

## Installation

You can install the package via composer:

```bash
composer require yungifez/artisan-ui
```

## Usage

You can use like so 

```php
 <div class=" m-4">
        <x-artisan-ui::alert title="hi"/>
        <x-artisan-ui::button>
            Button
        </x-artisan-ui::button>
        <x-artisan-ui::input placeholder="Hello" label="Hello"/>
        <x-artisan-ui::textarea placeholder="Hello" label="Hello"/>
        <x-artisan-ui::toggle label="Toggle"/>

        //a custom built multiple select box
        <x-artisan-ui::select label="" multiple>
            <option value="hh">Hey</option>
            <option value="K">Hey</option>
            <option value="POLKJ">Hey</option>
            <option value="KK">Hey</option>
            <option value="">Hey</option>
        </x-artisan-ui::select>
        <x-artisan-ui::accordion :group-together="true" :items="[
            [
                'title' => 'Hello world',
                'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam deleniti reprehenderit provident porro quo! Mollitia omnis suscipit, quaerat minima aliquam inventore, ex, sapiente fugit molestias dolor magni amet sit ducimus.'
            ],
            [
                'title' => 'What we do',
                'body' => 'Hello'
            ],
            [
                'title' => 'Why we do it',
                'body' => 'Hello'
            ]
        ]">

        </x-artisan-ui::accordion>
        <x-artisan-ui::loading-spinner />
    </div>
//which returns a 1 or 0

// the best part is, it still feels and works like normal html tags

// I call it HTML with super powers
```

The input components support old values and error messages

![image](https://github.com/yungifez/artisan-ui/assets/63137056/bc1aa03b-b363-428f-8533-2a9ffb057e0d)


