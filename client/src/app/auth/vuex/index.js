// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/import
import state from './state'
import mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'

const module = { state, mutations, actions, getters }

export default { module }
