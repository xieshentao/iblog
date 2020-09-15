<template>
  <div class="body">
    <template>
      <div class="main">
        <div class="nav">
          <div class="logo" v-on:click="goIndex">
            {{blogTitle}}
            <span>{{titleDesc}}</span>
          </div>
        </div>
        <div class="index-main">
          <div class="category-block">
            <el-badge value="php" class="item" style="user-select: none">
             <span class="category">异常处理</span>
            </el-badge>
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
                    :toolbars = "toolbars"
                    subfield = 'false'
                    defaultOpen = 'preview'
                    editable="false"
                    style="min-height: 800px"
                  />
                </div>
              </el-col>
              <el-col :span="4" class="operate-block"><div class="grid-content bg-purple-dark">222</div></el-col>
            </el-row>
          </div>
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
                loading:true,
                toolbars: {
                    bold: false, // 粗体
                    italic: false, // 斜体
                    header: false, // 标题
                    underline: false, // 下划线
                    strikethrough: false, // 中划线
                    mark: false, // 标记
                    superscript: false, // 上角标
                    subscript: false, // 下角标
                    quote: false, // 引用
                    ol: false, // 有序列表
                    ul: false, // 无序列表
                    link: false, // 链接
                    imagelink: false, // 图片链接
                    code: false, // code
                    table: false, // 表格
                    fullscreen: false, // 全屏编辑
                    readmodel: true, // 沉浸式阅读
                    htmlcode: false, // 展示html源码
                    help: false, // 帮助
                    /* 1.3.5 */
                    undo: false, // 上一步
                    redo: false, // 下一步
                    trash: false, // 清空
                    save: false, // 保存（触发events中的save事件）
                    /* 1.4.2 */
                    navigation: true, // 导航目录
                    /* 2.1.8 */
                    alignleft: false, // 左对齐
                    aligncenter: false, // 居中
                    alignright: false, // 右对齐
                    /* 2.2.1 */
                    subfield: true, // 单双栏模式
                    preview: true, // 预览
                }

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
                let name = 'test777';
                util.get(this.api + '/blog/view.json',{name:name},(res)=>{
                    if(res.success){
                        this.articleTitle = res.data.title;
                        this.articleContent = res.data.blogContent;
                    }else{
                        this.articleTitle = res.data.msg;
                    }
                    this.loading = false;
                });
            },
            dataChange(value,render){

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
            this.setScreen();
            this.getContent();
        }
    }
</script>

<style>
  body{
    margin:0 !important;
    background-image:url(../../../static/system/bk1.jpg); background-repeat:no-repeat; background-attachment:fixed;background-size:100%,100%
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
    opacity: 0.7;
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
    width: 1280px;
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
    opacity: 0.7;
    min-height: 400px;
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
