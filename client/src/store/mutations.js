// https://vuex.vuejs.org/en/mutations.html

import * as TYPES from './types'

/* eslint-disable no-param-reassign */
export default {
  [TYPES.MAIN_SET_TOKEN](state, obj) {
    state.token = obj.token
  },
  [TYPES.MAIN_SET_USER](state, obj) {
    state.user = obj.user
  },
  [TYPES.MAIN_SET_MESSAGE](state, obj) {
    state.messages[obj.type] = obj.message
  },
}
