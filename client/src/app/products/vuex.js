import * as TYPES from '../../store/types'

const state = {
  list: [],
  pagination: {},
}

/* eslint-disable no-param-reassign */
const mutations = {
  [TYPES.PRODUCTS_SET_DATA](st, obj) {
    st.list = obj.list
    st.pagination = obj.pagination
  },
}

const actions = {
  productsSetData({ commit }, obj) {
    commit(TYPES.PRODUCTS_SET_DATA, obj)
  },
}

const module = {
  state,
  mutations,
  actions,
}

export default { module }
