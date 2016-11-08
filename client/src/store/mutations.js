import * as TYPES from './types'

/* eslint-disable no-param-reassign */
export default {
  [TYPES.MAIN_SET_TOKEN](state, obj) {
    state.token = obj.token
  },
}
