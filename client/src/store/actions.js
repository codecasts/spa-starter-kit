import * as TYPES from './types'

export default {
  setToken: ({ commit }, token) => {
    commit(TYPES.MAIN_SET_TOKEN, {
      token,
    })
  },
}
