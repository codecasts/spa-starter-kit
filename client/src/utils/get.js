/* eslint-disable import/prefer-default-export */
import { get } from 'lodash'

/**
 * for functional approach, we have this abstraction
 * - const myObject = { data: [...], anotherKey: ... }
 * - const dataValue = getData(myObject) // instead of : const dataValue = myObject.data
 * We do this to make more easy to read and maintain a code
 * In addition, the code that goes to the browser can be more optimized and smaller
 *
 * Abstractions are powerful things, with small modifications this function can be more efficient
 * - const getData = (obj, defaultValue) => get(obj, 'data', defaultValue)
 * seet https://lodash.com/docs#get for more details
 */
export const getData = obj => get(obj, 'data')
