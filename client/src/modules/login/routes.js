
/**
* Components are lazy-loaded
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
const Login = (resolve) => {
  require.ensure(['./main'], () => {
    resolve(require('./main')) // eslint-disable-line global-require
  })
}

export default [
  {
    name: 'login.index',
    path: '/login',
    component: Login,
    meta: { requiresAuth: false },
  },
]
