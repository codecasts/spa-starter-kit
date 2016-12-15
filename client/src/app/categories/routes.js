
/**
* Components are lazy-loaded - See "Grouping Components in the Same Chunk"
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
/* eslint-disable global-require */
const Categories = r => require.ensure([], () => r(require('./main')), 'categories-bundle')
const Form = r => require.ensure([], () => r(require('./form')), 'categories-bundle')

const meta = {
  requiresAuth: true,
}

export default [
  {
    name: 'categories.index',
    path: '/categories',
    component: Categories,
    meta,
    children: [
      {
        name: 'categories.new',
        path: 'create',
        component: Form,
        meta,
      }, {
        name: 'categories.edit',
        path: ':id/edit',
        component: Form,
        meta,
      },
    ],
  },
]
