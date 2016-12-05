import { Main, Singup, Singin } from './components'

const children = [{
  name: 'auth.singin',
  path: 'singin',
  component: Singin,
  meta: { requiresAuth: false },
}, {
  name: 'auth.singup',
  path: 'singup',
  component: Singup,
  meta: { requiresAuth: false },
}]

export default [
  {
    children,
    name: 'auth',
    path: '/auth',
    redirect: { name: 'auth.singin' },
    component: Main,
    meta: { requiresAuth: false },
  },
]
