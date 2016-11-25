
/**
* Component is lazy-loaded
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
const Dashboard = (resolve) => {
  require.ensure(['./main'], () => {
    resolve(require('./main')) // eslint-disable-line global-require
  })
}

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
