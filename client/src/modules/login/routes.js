import component from './main'

export default [
  {
    name: 'login.index',
    path: '/login',
    component,
    meta: { requiresAuth: false },
  },
]
