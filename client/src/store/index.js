import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import mutations from './mutations'
import actions from './actions'

import Categories from '../modules/categories/state'

Vue.use(Vuex)

export default new Vuex.Store({
  state,
  mutations,
  actions,
  strict: process.env.NODE_ENV !== 'production',
  modules: {
    Categories,
  },
})
