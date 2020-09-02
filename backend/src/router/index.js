import Vue from 'vue';
import Router from 'vue-router';

//后台
import AdminIndex from '../view/admin/Index.vue';
import AdminBlogAdd from '../view/admin/BlogAdd.vue';
import AdminBlogList from '../view/admin/BlogList.vue';
import AdminBlogRecycle from '../view/admin/BlogRecycle.vue';
import AdminDiary from '../view/admin/Diary.vue';
import AdminLabel from '../view/admin/Label.vue';
import AdminUser  from '../view/admin/User.vue';
import AdminCount  from '../view/admin/Count.vue';
import AdminPlan  from '../view/admin/Plan.vue'
import AdminSetting from '../view/admin/Setting.vue';


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
      path: '/adminBlogAdd',
      name: 'AdminBlogAdd',
      component: AdminBlogAdd
    },
  {
    path: '/adminBlogList',
    name: 'AdminBlogList',
    component: AdminBlogList
  },
  {
    path: '/adminBlogRecycle',
    name: 'AdminBlogRecycle',
    component: AdminBlogRecycle
  },
  {
    path: '/adminDiary',
    name: 'AdminDiary',
    component: AdminDiary
  },
  {
    path: '/adminPlan',
    name: 'AdminPlan',
    component: AdminPlan
  },
  {
    path: '/adminLabel',
    name: 'AdminLabel',
    component: AdminLabel
  },
    {
      path: '/adminUser',
      name: 'AdminUser',
      component: AdminUser
    },
  {
    path: '/adminCount',
    name: 'AdminCount',
    component: AdminCount
  },
    {
      path: '/adminSetting',
      name: 'AdminSetting',
      component: AdminSetting
    },
];

export default new Router({
  mode: 'history',
  routes,
  base:''
})
