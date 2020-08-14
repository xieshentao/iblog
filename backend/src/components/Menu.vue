<template>
  <el-card class="box-card">
<el-row class="tac">
  <el-col :span="24">
    <el-menu
      v-bind:default-active="selected"
      class="el-menu-vertical-demo menu"
      @open="handleOpen"
      @close="handleClose"
      :router="true"
      >
      <el-menu-item index="admin">
        <i class="iconfont iconkongzhitai"></i>
        <span slot="title">控制台</span>
      </el-menu-item>
      <el-submenu index="">
        <template slot="title">
          <i class="iconfont iconblog"></i>
          <span>blog</span>
        </template>
        <el-menu-item-group>
          <el-menu-item index="adminBlogAdd">新增</el-menu-item>
          <el-menu-item index="adminBlogList">列表</el-menu-item>
          <el-menu-item index="adminBlogRecycle">回收站</el-menu-item>
        </el-menu-item-group>
      </el-submenu>
      <el-menu-item index="adminDiary">
        <i class="iconfont iconcb-chengchangriji"></i>
        <span slot="title">日记</span>
      </el-menu-item>
      <el-menu-item index="adminPlan">
        <i class="iconfont iconcb-chengchangriji"></i>
        <span slot="title">计划</span>
      </el-menu-item>
      <el-menu-item index="adminLabel">
        <i class="iconfont iconicon"></i>
        <span slot="title">分类&标签</span>
      </el-menu-item>
      <el-menu-item index="adminUser">
        <i class="iconfont iconyonghu"></i>
        <span slot="title">用户</span>
      </el-menu-item>
      <el-menu-item index="adminCount">
        <i class="iconfont icontongji"></i>
        <span slot="title">统计</span>
      </el-menu-item>
      <el-menu-item index="adminCollect">
        <i class="iconfont iconshoucang"></i>
        <span slot="title">收藏</span>
      </el-menu-item>
      <el-menu-item index="adminSetting">
        <i class="iconfont iconshezhi"></i>
        <span slot="title">设置</span>
      </el-menu-item>
    </el-menu>
  </el-col>
</el-row>
  </el-card>
</template>
<script>
  export default {
    data(){
      return {
        selected:"admin"
      };
    },
    methods: {
      handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      },
      initSelecteMenu(){
        const pathname = window.location.pathname;
        if(pathname == null) return;

        const selectedName = pathname.substr(1);
        if(selectedName == null) return;

        this.selected = selectedName;
      },
        //消息通知
        //今日未写日记  qq-mail
        //文章复习提示  qq-mail
      open() {
          const h = this.$createElement;

          this.$notify.info({
              title: '标题名称',
              position: 'bottom-right',
              message: h('i', { style: 'color: teal'}, '这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案')
          });
      },
    },
    created(){
      this.initSelecteMenu();
      //this.open();
    }

  }
</script>

<style>
  .menu{
    border: none !important;
  }
</style>
