import factories from './components.js';
import { component, components, extend, register, replace, resolve } from './registry.js';

Object.keys(factories).forEach((name) => component(name, factories[name]));

/**
 * Register April UI behaviours with an existing Alpine instance.
 *
 * Use this entry point when Livewire or the application already owns Alpine.
 */
export function registerApril(Alpine) {
    register(Alpine);

    return Alpine;
}

export { component, components, extend, register, replace, resolve };

export * from './livewire.js';

export default { component, components, extend, registerApril, replace, resolve };
