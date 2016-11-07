import Vue from 'vue'
import Router from 'vue-router'

import dashboard from '../modules/dashboard/routes'
import categories from '../modules/categories/routes'

Vue.use(Router)

const routes = [].concat(dashboard, categories)

const router = new Router({
  routes,
  mode: 'history',
})

export default router
