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
    editor: null,
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
        [':contenteditable']() {
            return !this.disabled;
        },
        ['@keydown'](event) {
            if (this.disabled) {
                event.preventDefault();
            }
        },
    },
    init() {
        this.editor = new Editor({
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
                this.$dispatch('input', { value: this.value });
                this.$dispatch('change', { value: this.value });
            },
        });

        this.$watch('value', (value) => {
            if (this.editor && value !== this.editor.getHTML()) {
                this.editor.commands.setContent(value || '', false);
            }
        });

        this.$watch('disabled', (disabled) => {
            this.editor?.setEditable(!disabled);
        });
    },
    destroy() {
        this.editor?.destroy();
    },
    isActive(button) {
        if (!this.editor) {
            return false;
        }

        if (button === 'heading') {
            return this.editor.isActive('heading');
        }

        return this.editor.isActive(button);
    },
    can(button) {
        if (!this.editor) {
            return false;
        }

        if (button === 'undo') {
            return this.editor.can().undo();
        }

        if (button === 'redo') {
            return this.editor.can().redo();
        }

        return true;
    },
    run(button) {
        if (!this.editor || this.disabled) {
            return;
        }

        if (button === 'undo') {
            this.editor.chain().focus().undo().run();
            return;
        }

        if (button === 'redo') {
            this.editor.chain().focus().redo().run();
            return;
        }

        if (button === 'link') {
            this.toggleLink();
            return;
        }

        if (button === 'horizontalRule') {
            this.editor.chain().focus().setHorizontalRule().run();
            return;
        }

        const command = commandNames[button];

        const chain = this.editor.chain().focus();

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
        if (!this.editor) {
            return;
        }

        if (this.editor.isActive('link')) {
            this.editor.chain().focus().unsetLink().run();
            return;
        }

        const url = window.prompt('Enter a URL');

        if (url) {
            this.editor.chain().focus().setLink({ href: url }).run();
        }
    },
});
