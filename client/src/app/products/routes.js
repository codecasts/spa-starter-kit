
/**
* Components are lazy-loaded - See "Grouping Components in the Same Chunk"
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
/* eslint-disable global-require */
const Products = r => require.ensure([], () => r(require('./main')), 'products-bundle')
const Form = r => require.ensure([], () => r(require('./form')), 'products-bundle')

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
