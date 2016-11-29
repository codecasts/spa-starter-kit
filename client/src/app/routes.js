import { routes as dashboard } from './dashboard'
import { routes as categories } from './categories'
import { routes as login } from './login'

export default [...login, ...dashboard, ...categories]
