import Vue from 'vue'
import Router from 'vue-router'

/**
* Routes are always stored close to
* the modules they help navigate to
*/
import dashboard from '../modules/dashboard/routes'
import categories from '../modules/categories/routes'
import login from '../modules/login/routes'

Vue.use(Router)

const routes = [].concat(login, categories, dashboard)

const router = new Router({
  routes,
  linkActiveClass: 'active',
  mode: 'history', // do not use /#/.
})

export default router
