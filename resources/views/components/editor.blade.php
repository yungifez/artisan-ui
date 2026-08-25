@props([
    'name' => '',
    'value' => '',
    'placeholder' => 'Write something...',
    'buttons' => null,
    'disabled' => false,
    'bold' => null,
    'italic' => null,
    'strike' => null,
    'heading' => null,
    'bulletList' => null,
    'orderedList' => null,
    'blockquote' => null,
    'codeBlock' => null,
    'link' => null,
    'undo' => null,
    'redo' => null,
    'horizontalRule' => null,
])

@php
    $availableButtons = [
        'bold' => true,
        'italic' => true,
        'strike' => true,
        'heading' => true,
        'bulletList' => true,
        'orderedList' => true,
        'blockquote' => true,
        'codeBlock' => true,
        'link' => true,
        'horizontalRule' => true,
        'undo' => true,
        'redo' => true,
    ];

    $buttonAliases = [
        'bullet-list' => 'bulletList',
        'ordered-list' => 'orderedList',
        'code-block' => 'codeBlock',
        'horizontal-rule' => 'horizontalRule',
    ];

    if (is_array($buttons)) {
        $availableButtons = array_fill_keys(
            array_map(fn ($button) => $buttonAliases[$button] ?? $button, $buttons),
            true
        ) + array_fill_keys(array_keys($availableButtons), false);
    }

    foreach ([
        'bold' => $bold,
        'italic' => $italic,
        'strike' => $strike,
        'heading' => $heading,
        'bulletList' => $bulletList,
        'orderedList' => $orderedList,
        'blockquote' => $blockquote,
        'codeBlock' => $codeBlock,
        'link' => $link,
        'undo' => $undo,
        'redo' => $redo,
        'horizontalRule' => $horizontalRule,
    ] as $button => $enabled) {
        if ($enabled !== null) {
            $availableButtons[$button] = filter_var($enabled, FILTER_VALIDATE_BOOL);
        }
    }

    $editorOptions = [
        'placeholder' => $placeholder,
        'disabled' => filter_var($disabled, FILTER_VALIDATE_BOOL),
    ];
@endphp

<div data-slot="editor" x-data="editor({{ \Illuminate\Support\Js::from($value) }}, {{ \Illuminate\Support\Js::from($editorOptions) }})"
    x-bind="root" x-modelable="value" {{$attributes->twMerge(['w-full rounded-md border border-input bg-background'])}}>
    @if ($name !== '')
        <input type="hidden" name="{{ $name }}" x-model="value">
    @endif

    <div data-slot="editor-toolbar" role="toolbar" aria-label="Text formatting"
        class="flex flex-wrap items-center gap-1 border-b border-input p-1">
        @foreach (['bold' => 'B', 'italic' => 'I', 'strike' => 'S'] as $button => $label)
            @if ($availableButtons[$button])
                <april:button type="button" variant="ghost" size="sm" aria-label="{{ ucfirst($button) }}"
                    x-on:click="run('{{ $button }}')"
                    x-bind:disabled="!can('{{ $button }}')"
                    x-bind:class="{ 'bg-accent text-accent-foreground': isActive('{{ $button }}') }">
                    <span class="{{ $button === 'italic' ? 'italic' : ($button === 'strike' ? 'line-through' : 'font-semibold') }}">{{ $label }}</span>
                </april:button>
            @endif
        @endforeach

        @if ($availableButtons['heading'])
            <april:button type="button" variant="ghost" size="sm" aria-label="Heading"
                x-on:click="run('heading')"
                x-bind:class="{ 'bg-accent text-accent-foreground': isActive('heading') }">
                <span class="font-semibold">H</span>
            </april:button>
        @endif

        @foreach (['bulletList' => '• List', 'orderedList' => '1. List', 'blockquote' => 'Quote', 'codeBlock' => 'Code'] as $button => $label)
            @if ($availableButtons[$button])
                <april:button type="button" variant="ghost" size="sm" aria-label="{{ $label }}"
                    x-on:click="run('{{ $button }}')"
                    x-bind:class="{ 'bg-accent text-accent-foreground': isActive('{{ $button }}') }">
                    {{ $label }}
                </april:button>
            @endif
        @endforeach

        @if ($availableButtons['link'])
            <april:button type="button" variant="ghost" size="sm" aria-label="Link"
                x-on:click="run('link')" x-bind:class="{ 'bg-accent text-accent-foreground': isActive('link') }">
                Link
            </april:button>
        @endif

        @if ($availableButtons['horizontalRule'])
            <april:button type="button" variant="ghost" size="sm" aria-label="Horizontal rule"
                x-on:click="run('horizontalRule')">
                Rule
            </april:button>
        @endif

        <span class="mx-1 h-5 w-px bg-border" aria-hidden="true"></span>

        @foreach (['undo' => 'Undo', 'redo' => 'Redo'] as $button => $label)
            @if ($availableButtons[$button])
                <april:button type="button" variant="ghost" size="sm" aria-label="{{ $label }}"
                    x-on:click="run('{{ $button }}')" x-bind:disabled="!can('{{ $button }}')">
                    {{ $label }}
                </april:button>
            @endif
        @endforeach
    </div>

    <div data-slot="editor-content" role="textbox" aria-multiline="true" x-ref="content" x-bind="content" data-placeholder="{{ $placeholder }}"
        class="min-h-32 w-full px-3 py-2 text-sm outline-none"></div>
</div>
