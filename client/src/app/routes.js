import { routes as dashboard } from './dashboard'
import { routes as categories } from './categories'
import { routes as login } from './login'

// https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/Operators/Spread_operator
// Thus a new array is created, containing all objects that match the routes.
export default [...login, ...dashboard, ...categories]
