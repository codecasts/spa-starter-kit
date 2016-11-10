import * as TYPES from '../../store/types'

const state = {
  list: [],
}

/* eslint-disable no-param-reassign */
const mutations = {
  [TYPES.CATEGORIES_SET_LIST](st, obj) {
    st.list = obj.list
  },
}

const actions = {
  categoriesSetList({ commit }, obj) {
    commit(TYPES.CATEGORIES_SET_LIST, obj)
  },
}

export default {
  state,
  mutations,
  actions,
}
