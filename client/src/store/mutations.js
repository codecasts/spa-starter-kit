// https://vuex.vuejs.org/en/mutations.html

import * as TYPES from './types'

/* eslint-disable no-param-reassign */
export default {
  [TYPES.MAIN_SET_FETCHING](state, obj) {
    state.fetching = obj.fetching
  },
  [TYPES.MAIN_SET_MESSAGE](state, obj) {
    state.messages[obj.type] = obj.message
  },
}
