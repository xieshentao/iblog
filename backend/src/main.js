// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import '../static/iconfont/iconfont.css'
import App from './App.vue'
import router from './router';
import store from './store';
import util from 'util';

Vue.use(ElementUI)

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
})
