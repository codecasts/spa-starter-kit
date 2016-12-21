// plugins is a alias. see client/build/webpack.base.conf.js
// import http client
import { http } from 'plugins/http'
import { getData } from 'utils/get'

/* eslint-disable import/prefer-default-export */
export const loadUserData = () => http.get('/me').then(getData)
