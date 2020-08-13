import Vue from 'vue';
import Router from 'vue-router';
import AdminIndex from '../view/admin/Index.vue';
import AdminSetting from '../view/admin/Setting.vue';
import AdminDiary from '../view/admin/Diary.vue';
import AdminLabel from '../view/admin/Label.vue';


Vue.use(Router)


const routes = [
    {
      path: '/',
      name: 'AdminIndex',
      component: AdminIndex
    },
    {
      path: '/admin',
      name: 'AdminIndex',
      component: AdminIndex
    },
    {
      path: '/adminSetting',
      name: 'AdminSetting',
      component: AdminSetting
    },
    {
      path: '/adminDiary',
      name: 'AdminDiary',
      component: AdminDiary
    },
    {
      path: '/adminLabel',
      name: 'AdminLabel',
      component: AdminLabel
    },
];

export default new Router({
  mode: 'history',
  routes,
  base:''
})
