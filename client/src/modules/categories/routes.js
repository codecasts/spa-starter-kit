
/**
* Component is lazy-loaded
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
const Categories = (resolve) => {
  require.ensure(['./main'], () => {
    resolve(require('./main')) // eslint-disable-line global-require
  })
}

export default [
  {
    name: 'categories.index',
    path: '/categorias',
    component: Categories,
    meta: { requiresAuth: true },
  },
]
