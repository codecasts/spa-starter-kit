// plugins and utils are alias. see client/build/webpack.base.conf.js
// import http client
import { http, setToken as httpSetToken } from 'plugins/http'
import { isEmpty } from 'lodash'
import { getData } from 'utils/get'
import { localStorageSetItem } from 'utils/local'
import * as TYPES from './mutations-types'

export const attemptLogin = ({ dispatch }, { email, password }) => http.post('/login', { email, password })
     /**
      * functional approach, more readable and generate minus code
      * examples:
      * PromiseObject.then(response => response.data)
      * PromiseObject.then({ data } => data)
      *
      * We do this many times in many locations.
      * We know that .then accepts a function and what arguments it receives
      * This is because in JavaScript functions are first class citizens.
      * In summary we can pass functions as arguments and also receive functions as results
      * (first-class function and higher-order function)
      */
    .then(getData) // .then(response => getData(response))
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
