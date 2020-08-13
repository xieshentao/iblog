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
        <i class="el-icon-setting"></i>
        <span slot="title">控制台</span>
      </el-menu-item>
      <el-submenu index="">
        <template slot="title">
          <i class="el-icon-location"></i>
          <span>blog</span>
        </template>
        <el-menu-item-group>
          <el-menu-item index="adminBlogAdd">新增</el-menu-item>
          <el-menu-item index="adminBlogList">列表</el-menu-item>
          <el-menu-item index="adminBlogRecycle">回收站</el-menu-item>
        </el-menu-item-group>
      </el-submenu>
      <el-menu-item index="adminDiary">
        <i class="el-icon-menu"></i>
        <span slot="title">日记</span>
      </el-menu-item>
      <el-menu-item index="adminLabel">
        <i class="el-icon-menu"></i>
        <span slot="title">分类&标签</span>
      </el-menu-item>
      <el-menu-item index="adminUser">
        <i class="el-icon-setting"></i>
        <span slot="title">用户</span>
      </el-menu-item>
      <el-menu-item index="adminCount">
        <i class="el-icon-setting"></i>
        <span slot="title">统计</span>
      </el-menu-item>
      <el-menu-item index="adminSetting">
        <i class="el-icon-setting"></i>
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
    },
    created(){
      this.initSelecteMenu();
    }

  }
</script>

<style>
  .menu{
    border: none !important;
  }
</style>
