
/**
* Components are lazy-loaded
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
const Main = (resolve) => {
  require.ensure(['./main'], () => {
    resolve(require('./main')) // eslint-disable-line global-require
  })
}

const Signin = (resolve) => {
  require.ensure(['./components/forms/login'], () => {
    resolve(require('./components/forms/login')) // eslint-disable-line global-require
  })
}

const Singup = (resolve) => {
  require.ensure(['./components/forms/singup'], () => {
    resolve(require('./components/forms/singup')) // eslint-disable-line global-require
  })
}

const children = [{
  name: 'auth.singin',
  path: 'singin',
  component: Signin,
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
