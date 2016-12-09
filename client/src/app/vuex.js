import { isFunction } from 'lodash'
import { vuex as Categories } from './categories'
import { vuex as Products } from './products'
import { vuex as Auth } from './auth'

const vuex = { Categories, Products, Auth };
const keys = Object.keys(vuex)
const modules = keys.reduce((acc, key) => ({ ...acc, [key]: vuex[key].module }), {})
const plugins = keys.reduce((acc, key) => [...acc, vuex[key].plugin], []).filter(isFunction)

// Shorthand for ‘Categories: Categories’
export default { modules, plugins }
