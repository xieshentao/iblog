// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css'
import '../static/iconfont/iconfont.css'
import App from './App.vue'
import router from './router';
import store from './store';
import VueCookies from 'vue-cookies';
Vue.use(VueCookies);
Vue.use(ElementUI);

/*router.beforeEach((to, from, next) => {
  // 如果有token 说明该用户已登陆
  let token = util.getCookie('iblog_user_auth');
  if (token) {
    // 在已登陆的情况下访问登陆页会重定向到首页
    if (to.path === '/Login') {
      next({path: '/Admin'})
    } else {
      next({path: to.path || '/Admin'})
    }
  } else {
    // 没有登陆则访问任何页面都重定向到登陆页
    if (to.path === '/Login') {
      next()
    } else {
      next(`/Login?redirect=${to.path}`)
    }
  }
});*/

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
});


