# Artisan UI

Artisan UI is a collection of reusable UI components made with Tailwind ALpinejs and Livewire carefully crafted to look good, be flexible and feel natural. The goal of Artisan UI is to feel like one is writing supercharged HTML.

## Installation

You can install Artisan UI through composer by running 

```shell
composer require yungifez/artisan-ui
```

## Usage 
The available components are 
1 Accordion
1 Alert
1 Avatar
1 Badge
1 Button
1 Card
1 Input
1 Loading Spinner
1 Modal
1 Select
1 Text Area
1 Toggle

### Accordion
```html
<x-artisan-ui::accordion>
         <x-artisan-ui::accordion-item>
                <x-slot:title>
                    title
                </x-slot:title>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 		 Magnam deleniti reprehenderit provident porro quo! Mollitia omnis suscipit, quaerat minima aliquam inventore, ex, sapiente fugit molestias dolor magni amet sit ducimus.'
         </x-artisan-ui::accordion-item>
         <x-artisan-ui::accordion-item>
                <x-slot:title>
                    title
                </x-slot:title>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam deleniti reprehenderit provident porro quo! Mollitia omnis suscipit, quaerat minima aliquam inventore, ex, sapiente fugit molestias dolor magni amet sit ducimus.'
      </x-artisan-ui::accordion-item>
</x-artisan-ui::accordion>
```