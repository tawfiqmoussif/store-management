import "./bootstrap";
// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './Main'



// router setup
import routes from './routes/routes'

// Plugins
import GlobalComponents from './globalComponents'
import GlobalDirectives from './globalDirectives'
import Notifications from './components/NotificationPlugin'
//wizard
import VueGoodWizard from 'vue-good-wizard';

Vue.use(VueGoodWizard);

// MaterialDashboard plugin
import MaterialDashboard from './material-dashboard'
//mbdvue
import 'bootstrap-css-only/css/bootstrap.min.css'; 
import 'mdbvue/build/css/mdb.css';

import Chartist from 'chartist'
//notification
import VueNotification from "@kugatsu/vuenotification";



require('./assets/css/bootstrap-rtl.css');
require('./assets/css/material-dashboard-rtl.css');

//



//
// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkExactActiveClass: 'nav-item active'
})



Vue.use(VueRouter)
Vue.use(MaterialDashboard)
Vue.use(GlobalComponents)
Vue.use(GlobalDirectives)
Vue.use(Notifications)
Vue.use(VueNotification, {
  timer: 20
})
//
const openRoutes=['login'];
router.beforeEach((to, from, next) => {
  if(openRoutes.includes(to.name)) {
    next()
  }else if(localStorage.getItem('token')){
    next()
  }else {
    next('/login')
  }
})
// global library setup
Object.defineProperty(Vue.prototype, '$Chartist', {
  get () {
    return this.$root.Chartist
  }
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  render: h => h(App),
  router,
  data: {
    Chartist: Chartist
  }
})
