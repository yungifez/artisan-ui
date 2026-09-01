import { Editor } from '@tiptap/core';
import Placeholder from '@tiptap/extension-placeholder';
import StarterKit from '@tiptap/starter-kit';

const commandNames = {
    bold: 'toggleBold',
    italic: 'toggleItalic',
    strike: 'toggleStrike',
    heading: 'toggleHeading',
    bulletList: 'toggleBulletList',
    orderedList: 'toggleOrderedList',
    blockquote: 'toggleBlockquote',
    codeBlock: 'toggleCodeBlock',
};

export default (value = '', options = {}) => ({
    value: value ?? '',
    options,
    disabled: Boolean(options.disabled),
    root: {
        [':data-disabled']() {
            return this.disabled || null;
        },
        [':data-state']() {
            return this.disabled ? 'disabled' : 'enabled';
        },
    },
    content: {
        [':aria-disabled']() {
            return this.disabled;
        },
        [':data-placeholder']() {
            return options.placeholder ?? '';
        },
        ['@keydown'](event) {
            if (this.disabled) {
                event.preventDefault();
            }
        },
    },
    init() {
        const editor = new Editor({
            element: this.$refs.content,
            extensions: [
                StarterKit.configure({
                    link: { openOnClick: false },
                }),
                Placeholder.configure({ placeholder: options.placeholder ?? '' }),
            ],
            content: this.value || '',
            editable: !this.disabled,
            onUpdate: ({ editor }) => {
                this.value = editor.getHTML();
                this.$dispatch('value-change', { value: this.value });
                this.$dispatch('input', { value: this.value });
                this.$dispatch('change', { value: this.value });
            },
        });

        // Tiptap owns mutable ProseMirror state. Keep it on the DOM node so
        // Alpine does not wrap it in a reactive Proxy.
        this.$refs.content._aprilEditor = editor;

        this.$watch('value', (value) => {
            if (this.getEditor() && value !== this.getEditor().getHTML()) {
                this.getEditor().commands.setContent(value || '', false);
            }
        });

        this.$watch('disabled', (disabled) => {
            this.getEditor()?.setEditable(!disabled);
        });
    },
    destroy() {
        this.getEditor()?.destroy();
        delete this.$refs.content._aprilEditor;
    },
    getEditor() {
        const editor = this.$refs.content?._aprilEditor ?? null;

        return window.Alpine?.raw ? window.Alpine.raw(editor) : editor;
    },
    isActive(button) {
        if (!this.getEditor()) {
            return false;
        }

        if (button === 'heading') {
            return this.getEditor().isActive('heading');
        }

        return this.getEditor().isActive(button);
    },
    can(button) {
        if (!this.getEditor()) {
            return false;
        }

        if (button === 'undo') {
            return this.getEditor().can().undo();
        }

        if (button === 'redo') {
            return this.getEditor().can().redo();
        }

        return true;
    },
    run(button) {
        if (!this.getEditor() || this.disabled) {
            return;
        }

        if (button === 'undo') {
            this.getEditor().chain().focus().undo().run();
            return;
        }

        if (button === 'redo') {
            this.getEditor().chain().focus().redo().run();
            return;
        }

        if (button === 'link') {
            this.toggleLink();
            return;
        }

        if (button === 'horizontalRule') {
            this.getEditor().chain().focus().setHorizontalRule().run();
            return;
        }

        const command = commandNames[button];

        const chain = this.getEditor().chain().focus();

        if (!command || typeof chain[command] !== 'function') {
            return;
        }

        if (button === 'heading') {
            chain[command]({ level: 2 }).run();
            return;
        }

        chain[command]().run();
    },
    toggleLink() {
        if (!this.getEditor()) {
            return;
        }

        if (this.getEditor().isActive('link')) {
            this.getEditor().chain().focus().unsetLink().run();
            return;
        }

        const url = window.prompt('Enter a URL');

        if (url) {
            this.getEditor().chain().focus().setLink({ href: url }).run();
        }
    },
});
