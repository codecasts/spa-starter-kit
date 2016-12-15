/**
* Components are lazy-loaded - See "Grouping Components in the Same Chunk"
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
/* eslint-disable global-require */
export const Main = r => require.ensure([], () => r(require('../components/main')), 'auth-bundle')
export const Singin = r => require.ensure([], () => r(require('../components/forms/singin')), 'auth-bundle')
export const Singup = r => require.ensure([], () => r(require('../components/forms/singup')), 'auth-bundle')
