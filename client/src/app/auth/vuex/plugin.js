import localforage from 'localforage'
import { userTokenStorageKey } from 'src/config'
import * as TYPES from './mutations-types'

const subscribe = (store) => {
  store.subscribe((mutation, { Auth }) => {
    if (TYPES.SET_TOKEN === mutation.type) {
      /**
       * Sets the token to the local storage
       * for auto-login purpose
       */
      localforage.setItem(userTokenStorageKey, Auth.token)
    }
  })
}

export default (store) => {
  subscribe(store)
};
