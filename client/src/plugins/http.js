import axios from 'axios'
import { apiUrl } from '../config'

const http = axios.create({
  baseURL: apiUrl,
})

export default function install(Vue) {
  Object.defineProperties(Vue.prototype, {
    $http: {
      get() {
        return http
      },
    },
  })
}
