
/**
* Components are lazy-loaded
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
const Products = (resolve) => {
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
    name: 'products.index',
    path: '/products',
    component: Products,
    meta,
    children: [
      {
        name: 'products.new',
        path: 'create',
        component: Form,
        meta,
      }, {
        name: 'products.edit',
        path: ':id/edit',
        component: Form,
        meta,
      },
    ],
  },
]
