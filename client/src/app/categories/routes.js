/**
 * Components are lazy-loaded
 * http://router.vuejs.org/en/advanced/lazy-loading.html
 *
 * const Categories = (resolve) => {
 *   require.ensure(['./main'], () => {
 *     resolve(require('./main')) // eslint-disable-line global-require
 *  })
 * }
 *
 * const Form = (resolve) => {
 *   require.ensure(['./form'], () => {
 *     resolve(require('./form')) // eslint-disable-line global-require
 *  })
 * }
 *
 * An alternative syntax used below, to group all components into a single
 * Webpack 'chunk' and JS file.
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
