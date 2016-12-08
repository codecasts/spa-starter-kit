import Vue from 'vue'
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
import Root from './Root'

/**
* This is the Vuex store and it is
* avaible to all your components
*/
import store from './store'

/**
* This is the Router
*/
import router from './router'

/**
* $http plugin based on axios
*/
import http from './plugins/http'

/**
* eventbus plugin
*/
import eventbus from './plugins/eventbus'

/**
* jQuery and Bootstrap includes
*/
require('./includes')

/**
* Element UI
*/
Vue.use(ElementUI, { locale })

/**
* Make $http avaible to all components
*/
Vue.use(http)

/**
* Make $bus avaible to all components
*/
Vue.use(eventbus)

/* eslint-disable no-new */
new Vue({
  store, // injects the Store into all components
  router, // make Router work with the application
  el: '#app',
  render: h => h(Root),
})
