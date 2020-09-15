<template>
    <div class="body">
      <template>
        <el-carousel indicator-position="none"
                     v-bind:height="height"
                     interval='7000' >
          <el-carousel-item v-for="item in imageSrc" :key="item">
            <img v-bind:src="item" height="100%" width="100%"/></el-carousel-item>
        </el-carousel>
        <div class="main">
          <div class="nav">
                <div class="logo" v-on:click="goIndex">
                  {{blogTitle}}
                  <span>{{titleDesc}}</span>
                </div>
          </div>
          <div class="index-main">
            <div class="search">
              <el-input
                placeholder="搜索"
                v-model="search"
                style="width: 500px;font-size: 17px"
              >
                <i slot="prefix" class="el-input__icon el-icon-search"></i>
              </el-input>
            </div>
            <div class="cate">
              <div class="category">
                <h3>分类</h3>
                大苏打 萨达大苏打
              </div>
            </div>
            <div class="show-Article">
              <el-button v-on:click="goArticle">所有文章</el-button>
            </div>
          </div>
        </div>
      </template>
    </div>
</template>

<script>
    export default {
        name: "index",
        data(){
            return{
                imageSrc:[
                    '../../../static/system/bk1.jpg',
                    '../../../static/system/bk2.jpg',
                ],
                title:'Iblog',
                title2:'记录每一天',
                blogTitle:'',
                titleDesc:'',
                search:'',
                height:'',
            }
        },
        methods:{
          showDesc(){
              let title = this.title2;
              let index = 0;
              let length = title.length;
              let tid = '';
              this.show = true;
              tid = setInterval(()=>{
                  this.titleDesc += title.charAt(index);
                  if(index ++ == length){
                      clearInterval(tid);
                  }
              },180);
          },
          showTitle(){
              let title = this.title;
              let index = 0;
              let length = title.length;
              let tid = '';
              this.show = true;
              tid = setInterval(()=>{
                  this.blogTitle += title.charAt(index);
                  if(index ++ == length){
                      clearInterval(tid);
                      this.showDesc();
                  }
              },250);

          },
          setScreen(){
              let height = document.documentElement.clientHeight;
              this.height = height+'px';
          },
          goIndex(){
            location.href = '/';
          },
          goArticle(){
            location.href = '/Article';
          }
        },
        mounted(){
          this.showTitle();
        },
        created() {
          this.setScreen();
        }
    }
</script>

<style>
  body{
    margin:0 !important;
  }

  .main{
    position: fixed;
    top:0px;
    left: 0px;
    z-index: 999;
    width: 100%;
    height: 1098px;
    overflow: auto;
    color: white;
  }

  .nav{
    position: absolute;
    top:30px;
    width: 100%;
    height: 60px;
    line-height: 60px;
    background: #393D49;
    opacity: 0.5;
    user-select: none;
  }

  .logo{
    font-weight: bold;
    font-size: 30px;
    margin: 0 auto;
    width: 1300px;
  }

  .logo span{
    font-size: 15px;
    font-family: '宋体';
  }

  .menu{
    float: right;
    font-size: 15px;
    display: inline;
  }

  .index-main{
    width: 1200px;
    min-height: 600px;
    position: absolute;
    top:130px;
    background: #393D49;
    left:50%;
    transform: translateX(-50%);
    opacity: 0.7;
    padding: 50px;
    overflow: auto;
  }

  .search{
    position: absolute;
    left:50%;
    transform: translateX(-50%);
  }

  .cate{
    position: absolute;
    top:170px;
    margin: 0px 30px;
    height: 470px;
    width: 800px;
    overflow: auto;
    left:50%;
    transform: translateX(-50%);
  }

  .show-Article{
    position: absolute;
    bottom: 30px;
    left:50%;
    transform: translateX(-50%);
  }
  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }

</style>
