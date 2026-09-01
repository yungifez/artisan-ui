/**
 * Bridge x-modelable April components to Livewire wire:model attributes.
 *
 * Native inputs keep Laravel's normal wire:model handling. This bridge covers
 * composite controls whose modelable value lives on a wrapper element.
 */
export function registerLivewireBridge(Alpine) {
    if (!Alpine || Alpine.__aprilLivewireBridgeRegistered) {
        return Alpine;
    }

    Alpine.__aprilLivewireBridgeRegistered = true;

    const isModelElement = (element) => [...element.attributes].some(({ name }) => name.startsWith('wire:model'));

    const bind = (root = document) => {
        if (!window.Livewire) {
            return;
        }

        const elements = root instanceof Element && isModelElement(root)
            ? [root]
            : [...root.querySelectorAll('*')].filter(isModelElement);

        elements.forEach((element) => {
            if (element.dataset.aprilWireModelBound === 'true') {
                return;
            }

            const modelable = element.getAttribute('x-modelable');
            const model = element._x_model || (modelable ? {
                get: () => Alpine.evaluate(element, modelable),
                set: (value) => Alpine.evaluate(element, modelable + ' = __aprilWireValue', {
                    scope: { __aprilWireValue: value },
                }),
            } : null);

            if (!model) {
                return;
            }

            const attribute = [...element.attributes].find(({ name }) => name.startsWith('wire:model'));
            const componentElement = element.closest('[wire\\:id]');
            const property = attribute?.value;
            const componentId = componentElement?.getAttribute('wire:id');
            const found = componentId ? window.Livewire.find(componentId) : null;
            const wire = found && (typeof found.$get === 'function' || typeof found.$set === 'function')
                ? found
                : found?.$wire;
            const get = typeof wire?.$get === 'function'
                ? wire.$get.bind(wire)
                : typeof wire?.get === 'function'
                    ? wire.get.bind(wire)
                    : null;
            const set = typeof wire?.$set === 'function'
                ? wire.$set.bind(wire)
                : typeof wire?.set === 'function'
                    ? wire.set.bind(wire)
                    : null;

            if (!attribute || !property || !get || !set) {
                return;
            }

            const live = /\.live|\.blur|\.change|\.lazy|\.debounce|\.throttle/.test(attribute.name);
            let syncing = false;
            let lastSent;

            const syncFromLivewire = () => {
                const value = get(property);
                const encoded = JSON.stringify(value);
                if (encoded === JSON.stringify(model.get())) {
                    return;
                }

                syncing = true;
                model.set(value);
                syncing = false;
            };

            Alpine.effect(() => {
                const value = model.get();
                const encoded = JSON.stringify(value);

                if (syncing || encoded === lastSent) {
                    return;
                }

                lastSent = encoded;
                set(property, value, live);
            });

            element.dataset.aprilWireModelBound = 'true';
            syncFromLivewire();
        });
    };

    document.addEventListener('alpine:initialized', () => bind());
    document.addEventListener('livewire:init', () => bind());
    document.addEventListener('livewire:navigated', () => bind());

    // Livewire can replace a composite control during a morph. Bind the new
    // wrapper after the morph so its x-modelable value remains connected.
    if (window.Livewire?.hook) {
        window.Livewire.hook('morph.updated', ({ el }) => bind(el));
    }

    return Alpine;
}
