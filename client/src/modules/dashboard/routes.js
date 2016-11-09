import component from './main'

export default [
  {
    name: 'dashboard.index',
    path: '/',
    component,
    meta: { requiresAuth: true },
  }, {
    name: 'catchall',
    path: '*',
    component,
    meta: { requiresAuth: true },
  },
]
