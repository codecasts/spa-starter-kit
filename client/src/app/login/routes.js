
/**
* Components are lazy-loaded - See "Grouping Components in the Same Chunk"
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
/* eslint-disable global-require */
const Login = r => require.ensure([], () => r(require('./main')), 'login-bundle')

export default [
  {
    name: 'login.index',
    path: '/login',
    component: Login,
    meta: { requiresAuth: false },
  },
]
