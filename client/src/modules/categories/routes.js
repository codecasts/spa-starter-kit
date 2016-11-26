
/**
* Components are lazy-loaded
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
const Categories = (resolve) => {
  require.ensure(['./main'], () => {
    resolve(require('./main')) // eslint-disable-line global-require
  })
}

const Form = (resolve) => {
  require.ensure(['./form'], () => {
    resolve(require('./form')) // eslint-disable-line global-require
  })
}

const meta = {
  requiresAuth: true,
}

export default [
  {
    name: 'categories.index',
    path: '/categorias',
    component: Categories,
    meta,
    children: [
      {
        name: 'categories.new',
        path: 'nova',
        component: Form,
        meta,
      },
    ],
  },
]
