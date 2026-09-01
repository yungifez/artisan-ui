import { component, components, extend, registerApril, replace, resolve } from './april-core.js';
import { registerLivewireBridge } from './livewire.js';

window.April = { components, component, extend, replace, resolve, register: registerApril };

document.addEventListener('alpine:init', () => {
    registerApril(window.Alpine);
    registerLivewireBridge(window.Alpine);
});
