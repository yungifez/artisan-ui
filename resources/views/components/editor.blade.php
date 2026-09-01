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
        class="flex flex-wrap items-center gap-1 border-b border-input p-1" x-on:mousedown.prevent>
        @foreach (['bold', 'italic', 'strike'] as $button)
            @if ($availableButtons[$button])
                <april:button type="button" variant="ghost" size="sm" aria-label="{{ ucfirst($button) }}"
                    x-on:click="run('{{ $button }}')"
                    x-bind:disabled="!can('{{ $button }}')"
                    x-bind:class="{ 'bg-accent text-accent-foreground': isActive('{{ $button }}') }">
                    @if ($button === 'bold')
                        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 4h6a4 4 0 0 1 0 8H6z" />
                            <path d="M6 12h7a4 4 0 0 1 0 8H6z" />
                        </svg>
                    @elseif ($button === 'italic')
                        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M14 4h6" />
                            <path d="M4 20h6" />
                            <path d="m15 4-6 16" />
                        </svg>
                    @else
                        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M6 6h12" />
                            <path d="M5 12h14" />
                            <path d="M6 18h12" />
                            <path d="m5 5 14 14" />
                        </svg>
                    @endif
                </april:button>
            @endif
        @endforeach

        @if ($availableButtons['heading'])
            <april:button type="button" variant="ghost" size="sm" aria-label="Heading"
                x-on:click="run('heading')"
                x-bind:class="{ 'bg-accent text-accent-foreground': isActive('heading') }">
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M6 4v16" />
                    <path d="M18 4v16" />
                    <path d="M6 12h12" />
                </svg>
            </april:button>
        @endif

        @foreach (['bulletList', 'orderedList', 'blockquote', 'codeBlock'] as $button)
            @if ($availableButtons[$button])
                <april:button type="button" variant="ghost" size="sm" aria-label="{{ $button === 'bulletList' ? 'Bullet list' : ($button === 'orderedList' ? 'Numbered list' : ($button === 'blockquote' ? 'Blockquote' : 'Code block')) }}"
                    x-on:click="run('{{ $button }}')"
                    x-bind:class="{ 'bg-accent text-accent-foreground': isActive('{{ $button }}') }">
                    @if ($button === 'bulletList')
                        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M9 6h11" /><path d="M9 12h11" /><path d="M9 18h11" />
                            <path d="M4 6h.01" /><path d="M4 12h.01" /><path d="M4 18h.01" />
                        </svg>
                    @elseif ($button === 'orderedList')
                        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M10 6h10" /><path d="M10 12h10" /><path d="M10 18h10" />
                            <path d="M4 4h1v4" /><path d="M4 8h2" /><path d="M4 11h1.5a1.5 1.5 0 0 1 0 3H4l2 2H4" />
                        </svg>
                    @elseif ($button === 'blockquote')
                        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 17H5a2 2 0 0 1-2-2v-3a5 5 0 0 1 5-5" />
                            <path d="M17 17h-2a2 2 0 0 1-2-2v-3a5 5 0 0 1 5-5" />
                        </svg>
                    @else
                        <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m8 9-4 3 4 3" /><path d="m16 9 4 3-4 3" /><path d="m14 5-4 14" />
                        </svg>
                    @endif
                </april:button>
            @endif
        @endforeach

        @if ($availableButtons['link'])
            <april:button type="button" variant="ghost" size="sm" aria-label="Link"
                x-on:click="run('link')" x-bind:class="{ 'bg-accent text-accent-foreground': isActive('link') }">
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                </svg>
            </april:button>
        @endif

        @if ($availableButtons['horizontalRule'])
            <april:button type="button" variant="ghost" size="sm" aria-label="Horizontal rule"
                x-on:click="run('horizontalRule')">
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 12h16" />
                </svg>
            </april:button>
        @endif

        <span class="mx-1 h-5 w-px bg-border" aria-hidden="true"></span>

        @foreach (['undo', 'redo'] as $button)
            @if ($availableButtons[$button])
                <april:button type="button" variant="ghost" size="sm" aria-label="{{ ucfirst($button) }}"
                    x-on:click="run('{{ $button }}')" x-bind:disabled="!can('{{ $button }}')">
                    <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        @if ($button === 'undo')
                            <path d="M9 14 4 9l5-5" /><path d="M4 9h9a7 7 0 0 1 7 7v1" />
                        @else
                            <path d="m15 14 5-5-5-5" /><path d="M20 9h-9a7 7 0 0 0-7 7v1" />
                        @endif
                    </svg>
                </april:button>
            @endif
        @endforeach
    </div>

    <div data-slot="editor-content" role="group" aria-label="Editable content" x-ref="content" x-bind="content" data-placeholder="{{ $placeholder }}"
        class="min-h-32 w-full px-3 py-2 text-sm outline-none"></div>
</div>
