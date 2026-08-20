/*
|--------------------------------------------------------------------------
| Component registry
|--------------------------------------------------------------------------
|
| April UI ships as a prebuilt bundle, so a user cannot edit the source of a
| component the way a Blade view is published. The registry gives the same
| control at runtime. Use `extend` to wrap a component, or `replace` to swap
| it out. Both run before Alpine starts, so `register` sees the final result.
|
*/

const components = {};

const extensions = {};

let alpine = null;

/**
 * Add a component to the registry.
 */
export function component(name, factory) {
    components[name] = factory;

    return factory;
}

/**
 * Wrap a component with new behaviour.
 *
 * The wrapper gets the current factory and must return a new factory:
 *
 *     April.extend('switchInput', (base) => (disabled) => {
 *         const parent = base(disabled);
 *
 *         return {
 *             ...parent,
 *             setSwitchState(value) {
 *                 parent.setSwitchState.call(this, value);
 *                 this.$dispatch('audit', { value });
 *             },
 *         };
 *     });
 *
 * Spread the parent object, do not put it on a prototype. Alpine only reads
 * the properties an object owns. Call a parent method with `.call(this)` to
 * keep the reactive `this`.
 */
export function extend(name, wrapper) {
    if (! components[name]) {
        throw new Error(`April UI has no component named "${name}".`);
    }

    if (! extensions[name]) {
        extensions[name] = [];
    }

    extensions[name].push(wrapper);

    refresh(name);

    return components[name];
}

/**
 * Replace a component, and drop every extension of it.
 */
export function replace(name, factory) {
    components[name] = factory;

    delete extensions[name];

    refresh(name);

    return factory;
}

/**
 * Build the final factory of a component.
 */
export function resolve(name) {
    const factory = components[name];

    if (! factory) {
        throw new Error(`April UI has no component named "${name}".`);
    }

    return (extensions[name] ?? []).reduce((base, wrap) => wrap(base), factory);
}

/**
 * Register every component with Alpine.
 */
export function register(Alpine) {
    alpine = Alpine;

    Object.keys(components).forEach((name) => Alpine.data(name, resolve(name)));

    return Alpine;
}

/**
 * Send a late change to Alpine.
 *
 * A component that is already on the page keeps the old behaviour, because
 * Alpine reads a factory once, when the element starts.
 */
function refresh(name) {
    if (! alpine) {
        return;
    }

    console.warn(
        `April UI: "${name}" changed after Alpine started. Elements that are already on the page keep the old behaviour. Make the change after @aprilScripts and before Alpine starts.`
    );

    alpine.data(name, resolve(name));
}

export { components, extensions };
