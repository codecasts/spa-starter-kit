// https://vuex.vuejs.org/en/actions.html

import * as TYPES from './types'
import { localStorageSetItem } from '../utils/local'
import { setToken as httpSetToken } from '../plugins/http'

export default {

  setFetching({ commit }, obj) {
    commit(TYPES.MAIN_SET_FETCHING, obj)
  },

  setMessage({ commit }, obj) {
    commit(TYPES.MAIN_SET_MESSAGE, obj)
  },

  resetMessages({ commit }) {
    commit(TYPES.MAIN_SET_MESSAGE, { type: 'success', message: '' })
    commit(TYPES.MAIN_SET_MESSAGE, { type: 'error', message: '' })
    commit(TYPES.MAIN_SET_MESSAGE, { type: 'warning', message: '' })
  },

  setToken({ commit }, token) {
    /**
    * Sets the token to the local storage
    * for auto-login purpose
    */
    localStorageSetItem('token', { token })

    /**
    * Set the Axios Authorization header with the token
    */
    httpSetToken(token)

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
