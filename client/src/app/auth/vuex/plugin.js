import { localStorageSetItem } from 'utils/local'
import * as TYPES from './mutations-types'

const subscribe = (store) => {
  store.subscribe((mutation, { Auth }) => {
    if (TYPES.SET_USER === mutation.type) {
      /**
       * Sets the user to the local storage
       * for auto-login purpose
       */
      localStorageSetItem('user', { user: Auth.user })
    }

    if (TYPES.SET_TOKEN === mutation.type) {
      /**
       * Sets the token to the local storage
       * for auto-login purpose
       */
      localStorageSetItem('token', { token: Auth.token })
    }
  })
}

export default (store) => {
  subscribe(store)
};
