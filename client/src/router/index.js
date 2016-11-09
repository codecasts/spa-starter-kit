import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'
import { localStorageGetItem } from '../utils/local'

/**
* Routes are always stored close to
* the modules they help navigate to
*/
import dashboard from '../modules/dashboard/routes'
import categories from '../modules/categories/routes'
import login from '../modules/login/routes'

Vue.use(Router)

const routes = [...login, ...categories, ...dashboard]

const router = new Router({
  routes,
  linkActiveClass: 'active',
  mode: 'history', // do not use /#/.
})

/**
* Before a route is resolved we check for
* the token if the route is marked as
* requireAuth.
*/
router.beforeEach((to, from, next) => {
  let token = store.state.token
  const auth = to.meta.requiresAuth

  if (token === '') {
    const localStoredToken = localStorageGetItem('token')
    const localStoredUser = localStorageGetItem('user')

    /**
    * Do we have token and user local stored?
    * If so then use it!
    */
    if (localStoredToken !== undefined && localStoredUser !== undefined) {
      token = localStorageGetItem('token').token
      store.dispatch('setToken', token)
      store.dispatch('setUser', localStoredUser.user)
    }
  }

  /**
  * If route doesn't require authentication
  * OR we have a token then let the route
  * be normally accessed.
  */
  if (auth === undefined || !auth || token !== '') {
    next()
  }

  /**
  * Otherwise  if authentication is required
  * AND the token is empty, then redirect to
  * login.
  */
  if (auth !== undefined && auth && token === '') {
    next({ name: 'login.index' })
  }
})

export default router
