import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import mutations from './mutations'
import actions from './actions'
import modules from './modules'

Vue.use(Vuex)

export default new Vuex.Store({
  state,
  mutations,
  actions,
  modules,
  strict: process.env.NODE_ENV !== 'production',
})
