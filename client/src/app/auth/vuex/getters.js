// http://vuex.vuejs.org/en/getters.html
import { isEmpty } from 'lodash'

// if has token, we assume that user is logged in our system
export const isLogged = ({ token }) => !isEmpty(token)
// get current user data
export const currentUser = ({ user }) => user
