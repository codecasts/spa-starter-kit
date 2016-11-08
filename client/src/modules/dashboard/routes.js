import Self from './main'

export default [
  {
    name: 'dashboard.index',
    path: '/',
    component: Self,
    meta: { requiresAuth: true },
  }, {
    name: 'catchall',
    path: '*',
    component: Self,
    meta: { requiresAuth: true },
  },
]
