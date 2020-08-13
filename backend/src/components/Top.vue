<template>
  <el-card class="box-card top-box">
  <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
    <el-submenu index="2" class="top-item">
      <template slot="title">小涛涛</template>
      <el-menu-item index="exit">About Me</el-menu-item>
      <el-menu-item index="exit">退出</el-menu-item>
    </el-submenu>
  </el-menu>
  </el-card>
</template>

<script>
  export default {
    data() {
      return {
        activeIndex: '1',
      };
    },
    methods: {
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      }
    }
  }
</script>

<style>
  .top-item{
    float: right !important;
  }
  .el-menu-demo{
    background-color: #F9F9F9;
    border-bottom: none !important;
  }
  .top-box .el-card__body{
    padding: 0 !important;
  }
  .top-box{
    margin-bottom:20px;
  }
</style>
