import store from '../store'
import { localStorageGetItem } from '../utils/local'

const beforeEach = (to, from, next) => {
  /**
  * Clears all global feedback message
  * that might be visible
  */
  store.dispatch('resetMessages')

  let token = store.state.token
  const auth = to.meta.requiresAuth

  /**
  * If there's no token stored in the state
  * then check localStorage:
  */
  if (token === '') {
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
}

export default beforeEach
