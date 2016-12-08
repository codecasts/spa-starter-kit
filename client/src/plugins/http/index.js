import axios from 'axios'
import interceptors from './interceptors'
import { apiUrl } from '../../config'

export const http = axios.create({
  baseURL: apiUrl,
})

/**
* Helper method to set the header with the token
*/
export function setToken(token) {
  http.defaults.headers.common.Authorization = `Bearer ${token}`
}

export default function install(Vue, { store, router }) {
  interceptors(http, store, router)
  Object.defineProperties(Vue.prototype, {
    $http: {
      get() {
        return http
      },
    },
  })
}
