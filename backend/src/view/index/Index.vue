<head>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>
<template>
  <div  v-bind:style="{height:height + 'px'}" class="body" style="background-image:url(../../../static/system/bk1.jpg); background-repeat:no-repeat; background-attachment:fixed;background-size:100%,100%">
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
          <div class="main-block" style="background-color: #333333">
            <div style="width: 401px;height: 200px;background-color: white;margin:16px">
              1
            </div>
            <div style="width: 401px;height: 200px;background-color: white;margin:16px">
              1
            </div>
            <div style="width: 401px;height: 200px;background-color: white;margin:16px">
              1
            </div>
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
                this.height = height;
            },
            goIndex(){
                location.href = '/';
            },
            goArticle(){
                location.href = '/Article';
            },
            getContent(){
                let name = 'test777';
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
                let name = 'test777';
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
            navigateChange(status,value){
                console.log(status,value)
            }
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
    min-height: 400px;
    border-radius: 1px;
    font-family: 'Fira Sans';
    display: flex;
    flex-wrap:wrap;

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
