// https://vuex.vuejs.org/en/actions.html

import * as TYPES from './types'
import { set as localStorageSetItem } from '../utils/local'

export default {
  setToken: ({ commit }, token) => {
    localStorageSetItem('token', { token })
    commit(TYPES.MAIN_SET_TOKEN, {
      token,
    })
  },
  setUser: ({ commit }, user) => {
    localStorageSetItem('user', { user })
    commit(TYPES.MAIN_SET_USER, {
      user,
    })
  },
}
