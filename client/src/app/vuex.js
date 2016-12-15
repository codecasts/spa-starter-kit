import { isFunction } from 'lodash'
import { vuex as Categories } from './categories'
import { vuex as Products } from './products'
import { vuex as Auth } from './auth'

// start extraction data from vuex modules
const vuex = { Categories, Products, Auth };
const keys = Object.keys(vuex)
// process and extract data (modules and plugins)
/**
 * this is a full functional approach
 * this code use reduce end immutability with spread operator to generate new object and array
 * refs
 * - https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/Reduce
 * - https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/Operators/Spread_operator
 * - https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions
 *
 * Immutability is very important concept from functional programming, that's prevents side effects
 * Together with the syntax of arrow function make the code more concise
 *
 * plugins have additional treatment, with `.filter`, because not every module has plugins
 */
const modules = keys.reduce((acc, key) => ({ ...acc, [key]: vuex[key].module }), {})
const plugins = keys.reduce((acc, key) => [...acc, vuex[key].plugin], []).filter(isFunction)
/**
 * semi-functional version
 * const modules = keys.reduce((acc, key) => {
 *   acc[key] = vuex[key].module
 *   return acc // without immutability
 *   return { ...acc } // with immutability
 * }, {})
 *
 * const plugins = keys.reduce((acc, key) => {
 *   acc.push(vuex[key].plugins)
 *   return acc // without immutability
 *   return [...acc] // with immutability
 * }).filter(plugin => isFunction(plugin))
 */
// end of extraction

// Shorthand for ‘modules: modules’
export default { modules, plugins }
