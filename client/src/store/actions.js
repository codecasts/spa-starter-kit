// https://vuex.vuejs.org/en/actions.html

import * as TYPES from './types'
import { localStorageSetItem } from '../utils/local'

export default {

  setMessage({ commit }, obj) {
    commit(TYPES.MAIN_SET_MESSAGE, obj)
  },

  setToken({ commit }, token) {
    /**
    * Sets the token to the local storage
    * for auto-login purpose
    */
    localStorageSetItem('token', { token })

    /**
    * Commit the mutation
    */
    commit(TYPES.MAIN_SET_TOKEN, {
      token,
    })
  },
  setUser({ commit }, user) {
    /**
    * Sets the user to the local storage
    * for auto-login purpose
    */
    localStorageSetItem('user', { user })

    /**
    * Commit the mutations
    */
    commit(TYPES.MAIN_SET_USER, {
      user,
    })
  },
}
