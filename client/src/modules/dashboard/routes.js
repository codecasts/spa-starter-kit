import Self from './main.vue'

export default [
  { name: 'dashboard.index', path: '/', component: Self, meta: { requiresAuth: true } },
  { name: 'catchall', path: '*', component: Self, meta: { requiresAuth: true } },
]
