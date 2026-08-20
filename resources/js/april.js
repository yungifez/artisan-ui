import factories from './components.js';
import { component, components, extend, register, replace, resolve } from './registry.js';

Object.keys(factories).forEach((name) => component(name, factories[name]));

window.April = { components, component, extend, replace, resolve, register };

document.addEventListener('alpine:init', () => register(window.Alpine));
