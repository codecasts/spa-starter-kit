import component from './main'

export default [
  {
    name: 'categories.index',
    path: '/categorias',
    component,
    meta: { requiresAuth: true },
  },
]
