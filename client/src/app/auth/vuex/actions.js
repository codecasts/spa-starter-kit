// plugins and utils are alias. see client/build/webpack.base.conf.js
import { http, setToken as httpSetToken } from 'plugins/http'
import { isEmpty } from 'lodash'
import { getData } from 'utils/get'
import { localStorageSetItem } from 'utils/local'
import * as TYPES from './mutations-types'

export const attemptLogin = ({ dispatch }, { email, password }) => http.post('/login', { email, password })
     // functional approach, more readable and generate minus code
     // .then(response => response.data)
     // .then({ data } => data)
     // .then(response => getData(response))
    .then(getData)
    .then(({ token, user }) => {
      dispatch('setUser', user)
      dispatch('setToken', token)

      return user // keep promise chain
    })

export const logout = ({ dispatch }) =>
    // call actions
   Promise.all([
     dispatch('setToken', null),
     dispatch('setUser', {}),
   ])


export const setUser = ({ commit }, user) => {
  /**
   * Sets the user to the local storage
   * for auto-login purpose
   */
  localStorageSetItem('user', { user })

  // Commit the mutations
  commit(TYPES.SET_USER, user)

  Promise.resolve(user) // keep promise chain
}

export const setToken = ({ commit }, payload) => {
  // prevent if payload is a object
  const token = (isEmpty(payload)) ? null : payload.token || payload
  /**
   * Sets the token to the local storage
   * for auto-login purpose
   */
  localStorageSetItem('token', { token })
  /**
   * Set the Axios Authorization header with the token
   */
  httpSetToken(token)

  // Commit the mutations
  commit(TYPES.SET_TOKEN, token)

  return Promise.resolve(token) // keep promise chain
}
