import store from '../store'
import { isEmpty } from 'lodash'
import { localStorageGetItem } from '../utils/local'

const needAuth = (auth, token) => auth !== undefined && auth && isEmpty(token)

const beforeEach = (to, from, next) => {
  /**
  * Clears all global feedback message
  * that might be visible
  */
  store.dispatch('resetMessages')

  let token = store.state.Auth.token
  const auth = to.meta.requiresAuth
  /**
  * If there's no token stored in the state
  * then check localStorage:
  */
  if (isEmpty(token)) {
    const localStoredToken = localStorageGetItem('token')
    const localStoredUser = localStorageGetItem('user')

    /**
    * Do we have token and user local stored?
    * If so then use it!
    */
    if (localStoredToken !== undefined &&
        localStoredToken !== null &&
        localStoredUser !== undefined &&
        localStoredUser !== null
      ) {
      token = localStoredToken.token
      store.dispatch('setToken', token)
      store.dispatch('setUser', localStoredUser.user)
    }
  }

  /**
  * If route doesn't require authentication
  * OR we have a token then let the route
  * be normally accessed.
  */
  if (!needAuth(auth, token)) {
    next()
  }

  /**
  * Otherwise  if authentication is required
  * AND the token is empty, then redirect to
  * login.
  */
  if (needAuth(auth, token)) {
    next({ name: 'auth.singin' })
  }
}

export default beforeEach
