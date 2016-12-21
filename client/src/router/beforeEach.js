import store from '../store'

const needAuth = auth => auth === true

const beforeEach = (to, from, next) => {
  /**
  * Clears all global feedback message
  * that might be visible
  */
  store.dispatch('resetMessages')

  const auth = to.meta.requiresAuth

  /**
  * If route doesn't require authentication
  * be normally accessed.
  */
  if (!needAuth(auth)) {
    next()
  }

  /**
  * Otherwise  if authentication is required
  * login.
  */
  if (needAuth(auth)) {
    store.dispatch('checkUserToken')
      .then(() => {
        next()
      })
      .catch((err) => {
        console.log({ err });
        next({ name: 'auth.singin' })
      })
  }
}

export default beforeEach
