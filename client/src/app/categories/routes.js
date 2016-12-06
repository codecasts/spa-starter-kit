/**
 * Group components for code splitting in Web pack
 *
 * http://router.vuejs.org/en/advanced/lazy-loading.html
 */

const Categories = r => require.ensure([], () => r(require('./main.vue')), 'categories-bundle')
const Form = r => require.ensure([], () => r(require('./form.vue')), 'categories-bundle')

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
