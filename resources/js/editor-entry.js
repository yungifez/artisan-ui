import editor from './editor.js';

const registerEditor = (Alpine) => {
    if (!Alpine || Alpine.__aprilEditorRegistered) {
        return Alpine;
    }

    Alpine.data('editor', editor);
    Alpine.__aprilEditorRegistered = true;

    return Alpine;
};

if (window.Alpine) {
    registerEditor(window.Alpine);
}

document.addEventListener('alpine:init', () => registerEditor(window.Alpine), { once: true });
