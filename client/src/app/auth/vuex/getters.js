import { isEmpty } from 'lodash'

export const isLogged = ({ token }) => !isEmpty(token)
export const currentUser = ({ user }) => user
