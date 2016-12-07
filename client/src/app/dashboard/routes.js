
/**
* Components are lazy-loaded - See "Grouping Components in the Same Chunk"
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
/* eslint-disable global-require */
const Dashboard = r => require.ensure([], () => r(require('./main')), 'dashboard-bundle')

export default [
  {
    name: 'dashboard.index',
    path: '/',
    component: Dashboard,
    meta: { requiresAuth: true },
  }, {
    name: 'catchall',
    path: '*',
    component: Dashboard,
    meta: { requiresAuth: true },
  },
]
