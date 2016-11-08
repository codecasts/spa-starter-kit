import Self from './main'

export default [
  {
    name: 'categories.index',
    path: '/categorias',
    component: Self,
    meta: { requiresAuth: true },
  },
]
