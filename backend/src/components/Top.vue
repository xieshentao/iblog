<template>
  <el-card class="box-card top-box">
  <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
    <el-menu-item>Iblog&nbsp;&nbsp;&nbsp;美好的事情在等着你</el-menu-item>
    <el-submenu index="2" class="top-item">
      <template slot="title">小涛涛</template>
      <el-menu-item index="about">About Me</el-menu-item>
      <el-menu-item index="exit" v-on:click="exit">退出</el-menu-item>
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
      },
        exit(){
            this.$cookies.remove('iblog_user_auth');
            location.href = '/Login';
        }
    }
  }
</script>

<style>
  #app-name{
    display: inline;
    margin-left: 20px;
    color: white;
  }

  .top-item{
    float: right !important;
  }
  .el-menu-demo{
    border-bottom: none !important;
  }
  .top-box .el-card__body{
    padding: 0 !important;
  }
  .top-box{
    margin-bottom:20px;
    background-color: #393D49;
  }
</style>
