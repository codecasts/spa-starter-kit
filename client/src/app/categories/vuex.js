import * as TYPES from '../../store/types'

const state = {
  list: [],
  full_list: [],
  pagination: {},
}

/* eslint-disable no-param-reassign */
const mutations = {
  [TYPES.CATEGORIES_SET_DATA](st, obj) {
    if (obj.list) {
      st.list = obj.list
    }
    if (obj.full_list) {
      st.full_list = obj.full_list
    }
    if (obj.pagination) {
      st.pagination = obj.pagination
    }
  },
}

const actions = {
  categoriesSetData({ commit }, obj) {
    commit(TYPES.CATEGORIES_SET_DATA, obj)
  },
}

const module = {
  state,
  mutations,
  actions,
}

export default { module }
