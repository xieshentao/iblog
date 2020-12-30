<head>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>
<template>
  <div   class="body" v-bind:style="backgroundStyle">
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
        <div class="index-main"  v-loading="loading">
          <div class="category-block" style="display: flex;flex-wrap:wrap;">
            <div v-for="category in categorys" class="category-item" style="margin: 10px 40px;">
              <el-badge  :value="category.parent" class="item" :type="category.type" style="user-select: none;">
                <span class="category">{{category.name}}</span>
              </el-badge>
            </div>
          </div>
          <div class="main-block" style="background-color: rgba(51,54,51,0.8)">
            <div v-for="(item,index) in blogList" style="width: 47%;height: 220px;background-color: white;margin:16px">
              <el-row style="height: 100%">
                <el-col :span="7" v-bind:style="{'background-color':blockColor[index],'height':'100%','display':'block','padding':'15px 15px'}" style="box-shadow: 6px 6px 6px 6px rgba(0, 0, 0, 0.6) inset;color:white ">
                  <div style="display: flex;flex-direction: column;justify-content: space-around;height: 100%">

                    <img :src="item.avatar" style="width: 70px;height: 70px;border-radius: 50%">
                    {{item.name}}
                    <div style="font-size: 10px">
                     发布时间<br/>{{item.publish_time}}<br/>
                     最后修改<br/>{{item.modifyd_time}}<br/>
                    </div>

                  </div>
                </el-col>
                <el-col :span="17">
                  <div style="overflow: hidden;max-height: 100px;text-align: center">
                    <el-link v-bind:href="'/Article?name=' + item.title" target="" :underline="false" ><h1>{{item.title}}</h1></el-link>
                  </div>
                  <el-row v-html="item.html" style="overflow: hidden;display: block;border-top: 1px solid #e6e6e6;font-size: 12px;max-height: 120px;padding: 5px">
                  </el-row>
                </el-col>
              </el-row>
            </div>
            <div style="margin:30px 0px">
            <el-pagination
              background
              :curr-page="nowPage"
              layout="prev, pager, next"
              @current-change="pageChange"
              :hide-on-single-page="true"
              :total="totalCount">
            </el-pagination>
            </div>
          </div>
        </div>
        <div class="footer">

        </div>
        <img src="../../../static/system/haimian.gif" style="position: fixed;bottom: 10px;width: 100px;height: auto">
        <img src="../../../static/system/paidaxin.gif" style="position: fixed;bottom: 10px;right:0px;width: 100px;height: auto">
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
                backgroundStyle:{
                    backgroundImage:"url(../../../static/system/bk1.jpg)",
                    backgroundRepeat:"no-repeat",
                    backgroundAttachment:"fixed",
                    backgroundSize:"100%,100%",
                    minHeight:"",
                },
                imageSrc:[
                    '../../../static/system/bk5.jpg',
                    '../../../static/system/bk8.jpg',
                    '../../../static/system/bk9.jpg',
                    '../../../static/system/bk10.jpg',
                ],
                color:['#66FFFF','#FF9966','#2E8B57','#99CCCC','#FFCC99','#99CC99','#336633','#99CCFF','#99CC99',
                    '#66CCCC','#CCCCFF','#6666CC','#CCCC00','#99CC99','#66CCCC','#FF9900','#FFFFCC','#FF6666'],
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
                blogList:[],
                blockColor:[],
                totalCount:0,
                nowPage:1,
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
            pageChange(val){
              this.nowPage = val;
              this.getBlogList();
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
            },
            getBlogList(){
                const data = {
                    page:this.nowPage
                };

                util.get(this.api + '/blog/show_list.json',data,(res)=>{
                    if(res.success){
                        this.getColor(res.data.data);
                        this.blogList = res.data.data;
                        this.totalCount = res.data.count;
                        this.loading = false;
                    }else{

                    }

                });
            },
            getColor:function(blogList){
                for (let i=0;i<blogList.length;i++){
                let index = util.randomNum(0,this.color.length - 1);
                this.blockColor.push(this.color[index]);
                }
            },
            setBackground:function () {
                this.backgroundStyle.minHeight = this.height+"px";
                let index = util.randomNum(0,this.imageSrc.length - 1)
                this.backgroundStyle.backgroundImage = "url("+this.imageSrc[index]+")"
            },

        },
        computed: {
            ...mapState({
                api: state => state.api,
            }),
        },
        mounted(){
            this.showTitle();
        },
        created() {
            this.setScreen();
            this.setBackground();
            this.getContent();
            this.getShowTags();
            this.getCategorys();
            this.getShowCategory();
            this.getBlogList();
        },
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
    justify-content: space-around;

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
