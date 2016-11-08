import * as TYPES from './types'

export default {
  setToken: ({ commit }, token) => {
    commit(TYPES.MAIN_SET_TOKEN, {
      token,
    })
  },
  setUser: ({ commit }, user) => {
    commit(TYPES.MAIN_SET_USER, {
      user,
    })
  },
}
