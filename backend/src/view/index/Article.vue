<template>
  <div class="body" style="background-image:url(../../../static/system/bk1.jpg); background-repeat:no-repeat; background-attachment:fixed;background-size:100%,100%">
    <template>
      <div class="main">
        <div class="nav">
          <div class="logo">
            <div style="display: inline" v-on:click="goIndex">{{blogTitle}}
              <span>{{titleDesc}}</span></div>
            <el-input
              placeholder="搜索"
              prefix-icon="el-icon-search"
              v-model="search" style="display: inline;float: right;width: 200px">
            </el-input>
          </div>
        </div>
        <div class="index-main">
          <div class="category-block" style="display: flex;flex-wrap:wrap;">
            <div v-for="category in categorys" class="category-item" style="margin: 10px 40px;">
              <el-badge  :value="category.parent" class="item" :type="category.type" style="user-select: none;">
               <span class="category">{{category.name}}</span>
              </el-badge>
            </div>
          </div>
          <div class="main-block">
            <el-row>
              <el-col :span="20" class="content-block" v-loading="loading">
                <div style="text-align: center;margin:5px"><h1>{{articleTitle}}</h1></div>
                <div class="content">
                  <mavon-editor
                    v-model="articleContent"
                    ref="md"
                    @change="dataChange"
                    @navigationToggle = "navigateChange"
                    :toolbars = "toolbars"
                    :subfield = 'false'
                    defaultOpen = 'preview'
                    :editable = "false"
                    :ishljs = "true"
                    style="min-height: 800px;z-index: 888;"
                  />
                </div>
              </el-col>
              <el-col :span="4" class="operate-block" style="color:#FFFDEF;padding: 6px;">
                <div style="text-align: center;">
                   <el-image
                        style="width: 70px; height: 70px;border-radius: 35px;"
                        :src="avatar"
                        fit="fill">
                  </el-image>
                  <div>{{user}}</div>
                  <div style="font-size: 13px;color: #969896;">发布于{{publishTime}}</div>
                </div>
                <h3>分类</h3>
                <div style="font-size: 13px;color: #969896;">
                  <p>我去的撒旦das/dasddas>asddas</p>
                  <p>我去的撒旦dasdasddas>dasddas></p>
                  <p>我去的撒旦das/dasddas>dasddas></p>
                </div>
                <h3>标签</h3>
                <el-tag type="info" v-for="(item,index) in showTags" :key="index" style="margin:0px 0px 5px 5px;user-select: none;">{{item}}</el-tag>
                <h3>相似文章</h3>
                <div style="font-size: 13px;color: #969896;">
                  <p>我去的撒旦das/dasddas>asddas</p>
                  <p>我去的撒旦dasdasddas>dasddas></p>
                  <p>我去的撒旦das/dasddas>dasddas></p>
                </div>
              </el-col>
            </el-row>
          </div>
        </div>
        <div class="footer">

        </div>
      </div>
    </template>
  </div>
</template>

<script>

    import {mapState} from "vuex";
    import util from "@/util";
    import { mavonEditor } from 'mavon-editor'
    import 'mavon-editor/dist/css/index.css'
    export default {
        name: "index",
        components: {
            mavonEditor,
        },
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
                articleTitle:'',
                articleContent:'',
                user:'',
                publishTime:'',
                avatar:'',
                loading:true,
                toolbars: {
                    readmodel: true, // 沉浸式阅读
                    navigation: true, // 导航目录
                },
                showTags:[],
                showCategory:[],
                categorys:[],
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
            },
            getContent(){
                let name = this.articleTitle;
                util.get(this.api + '/blog/view.json',{name:name},(res)=>{
                    if(res.success){
                        this.articleTitle = res.data.title;
                        this.articleContent = res.data.blogContent;
                        this.user = res.data.user;
                        this.avatar = res.data.avatar;
                        this.publishTime = res.data.publishTime;
                    }else{
                        this.articleTitle = res.data.msg;
                    }
                    this.loading = false;
                });
            },
            getShowTags(){
              let name = this.articleTitle;
              util.get(this.api + '/blog/show_tags.json',{name:name},(res)=>{
                  if(res.success){
                      this.showTags = res.data.tags;

                  }else{

                  }

              });
            },
            getShowCategory(){
                util.get(this.api + '/blog/show_category.json',{name:name},(res)=>{
                    if(res.success){
                        this.showCategory = res.data.category;
                    }else{

                    }
                });
            },
            getCategorys(){
              util.get(this.api + '/blog/show_categorys.json',{name:name},(res)=>{
                  if(res.success){
                      this.categorys = res.data.category;
                  }else{

                  }

              });
            },
            dataChange(value,render){

            },

            //设置标题跳转锚
            navigateChange(status,value){
               if(status){
                   this.$nextTick(() => {
                       let elements = document.getElementsByClassName("v-note-navigation-content")[0];
                       let children = elements.children;

                       for(let i=0;i<children.length;i++){
                           let aTags = children[i].getElementsByTagName('a')[0];
                           if(aTags){
                               children[i].addEventListener("click",function(){
                                   location.href = '#'+aTags.id;
                                   window.scrollTo(window.scrollX,window.scrollY - 100);
                               });
                           }
                       }
                   });
               }
            },
            setFrame(){
                var scrollFunc = function(e){
                    e=e || window.event;
                    console.log(1111);
                }
                if(document.addEventListener){
                    document.addEventListener('onscroll',scrollFunc,false);//火狐
                }//W3C
                window.onmousewheel=document.onmousewheel=scrollFunc;//IE/Opera/Chrome
            },
        },
        computed: {
            ...mapState({
                api: state => state.api,
            })
        },
        mounted(){
            this.showTitle();
        },
        created() {
            //设置标题名
            this.articleTitle = decodeURI(util.getQueryVariable('name'));
            //设置 标题区域，其他信息区域 位置
            this.setFrame();
            this.setScreen();
            this.getContent();
            this.getShowTags();
            this.getCategorys();
            this.getShowCategory();

        }
    }
</script>

<style>
  body{
    margin:0 !important;

  }

  .main{
    z-index: 888;
    width: 100%;
    min-height: 600px;
    overflow: auto;
    color: white;
  }

  .nav{
    position: fixed;
    top:30px;
    width: 100%;
    height: 60px;
    line-height: 60px;
    background: #393D49;
    opacity: 0.9;
    user-select: none;
    z-index: 999;
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
    margin-right: 100px;
    display: inline;
  }

  .index-main{
    width: 100%;
    margin-top: 100px;
    color: #333333;
  }

  .category-block{
    width: 1300px;
    margin: 0 auto;
    padding: 10px 0 20px 0;
    border-radius: 1px;
  }

  .content-block{
    background-color:#fff;
    padding: 20px 5px;
  }

  .main-block{
    width: 1300px;
    margin: 0 auto;
    min-height: 600px;
    border-radius: 1px;
    font-family: 'Fira Sans';
  }

  .category{
    color: #FFFFFF;
    user-select: none;
    font-family: 'Fira Sans';
  }

  .operate-block{
    background-color: #393D49;
    opacity: 0.9;
    min-height: 400px;
  }

  .footer{
   height: 300px;
  }
  /*编辑器样式修改*/

  .v-note-op{
    position: absolute !important;
    top:0px;
    left:0px;
    width: 248px !important;
    background-color: rgb(251, 251, 251) !important;
    border: none !important;
  }

  .v-note-navigation-wrapper{
    position: absolute !important;
    top:0px !important;
    left:0px;
    width: 248px !important;
    background-color: rgb(251, 251, 251) !important;
    border: none !important;
  }

  .v-show-content{
    width: 824px !important;
    float: right !important;
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
