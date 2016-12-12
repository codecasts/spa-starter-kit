// plugins and utils are alias. see client/build/webpack.base.conf.js
// import http client
import { http, setToken as httpSetToken } from 'plugins/http'
import { isEmpty } from 'lodash'
import { getData } from 'utils/get'
import * as TYPES from './mutations-types'

export const attemptLogin = ({ dispatch }, { email, password }) => http.post('/auth/token/issue', { email, password })
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

export const logout = ({ dispatch }) => {
  http.post('/auth/token/revoke')
  // call actions
  return Promise.all([
    dispatch('setToken', null),
    dispatch('setUser', {}),
  ])
}

export const setUser = ({ commit }, user) => {
  // Commit the mutations
  commit(TYPES.SET_USER, user)

  Promise.resolve(user) // keep promise chain
}

export const setToken = ({ commit }, payload) => {
  // prevent if payload is a object
  const token = (isEmpty(payload)) ? null : payload.token || payload

  /**
   * Set the Axios Authorization header with the token
   */
  httpSetToken(token)

  // Commit the mutations
  commit(TYPES.SET_TOKEN, token)

  return Promise.resolve(token) // keep promise chain
}
