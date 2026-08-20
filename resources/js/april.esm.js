/*
| The bundler entry point. It registers every component with Alpine, the same
| as the browser build, and it also exports each factory. Import a factory
| when you want to build your own component out of it.
*/

import './april.js';

export { component, components, extend, register, replace, resolve } from './registry.js';

export * from './components.js';
