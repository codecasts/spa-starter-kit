import Vue from 'vue'
import Router from 'vue-router'

/**
* Routes are always stored close to
* the modules they help navigate to
*/
import dashboard from '../modules/dashboard/routes'
import categories from '../modules/categories/routes'

Vue.use(Router)

const routes = [].concat(dashboard, categories)

const router = new Router({
  routes,
  linkActiveClass: 'active',
  mode: 'history', // do not use /#/.
})

export default router
