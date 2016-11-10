import * as TYPES from '../../store/types'

const state = {
  pager: {},
}

/* eslint-disable no-param-reassign */
const mutations = {
  [TYPES.CATEGORIES_SET_PAGER](st, obj) {
    st.pager = obj.pager
  },
}

const actions = {
  categoriesSetPager({ commit }, obj) {
    commit(TYPES.CATEGORIES_SET_PAGER, obj)
  },
}

export default {
  state,
  mutations,
  actions,
}
