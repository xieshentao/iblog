<template>
  <div class="hello">
    <el-row>
      <Top></Top>
    </el-row>
    <el-row>
      <el-col :span="3">
        <LeftMenu></LeftMenu>
      </el-col>
      <el-col :span="21" class="main-content">
        <el-card class="box-card">
          <el-row gutter="20" class="">
            <el-col :span="20">
              <el-input v-model="blogTitle" id = 'blog-title' placeholder="“请输入标题”"></el-input>
              <mavon-editor
                v-model="blogContent"
                ref="md"
                @change="dataChange"
                style="min-height: 600px"
              />
            </el-col>
            <el-col :span="4">
              <el-row>
                <el-col :span="12"><el-button plain style="width: 90%" v-on:click="saveBlog">保存</el-button></el-col>
                <el-col :span="12"><el-button type="primary" style="width: 90%">发布</el-button></el-col>
              </el-row>
              <el-row>
               <h3>标签</h3>
                <el-select
                  v-model="selectedTags"
                  multiple
                  filterable
                  allow-create
                  default-first-option
                  placeholder="请选择文章标签" style="width: 95%">
                  <el-option
                    v-for="item in tags"
                    :key="item"
                    :value="item">
                  </el-option>
                </el-select>
                <h3>分类</h3>
                <div style="max-height: 220px;overflow: auto">
                <el-tree
                  :data="categoryData"
                  show-checkbox
                  node-key="id"
                  :default-expanded-keys="[]"
                  :default-checked-keys="[]"
                  :props="defaultProps">
                </el-tree>
                </div>
                <el-link v-if="!isAddCategoryNow" v-on:click="isAddCategoryNow = !isAddCategoryNow" type="primary">添加新分类</el-link>
                <!--添加新标签-->
                <el-row v-else>
                  <el-select v-model="parentCategory" placeholder="——父级分类名称——" style="width:95%;margin: 8px 0px;">
                    <el-option
                      v-for="item in parentCategoryData"
                      :key="item"
                      :label="item"
                      :value="item">
                    </el-option>
                  </el-select>
                  <el-input v-model="categoryName" placeholder='分类名称' style="width:95%;margin-bottom: 8px;"></el-input>
                  <div>
                    <el-link  type="primary" v-on:click="confirmAddCategory">确定</el-link>
                    <el-link  type="primary" v-on:click="isAddCategoryNow = !isAddCategoryNow">取消</el-link>
                  </div>
                </el-row>

                <h3>可见</h3>
                <el-switch
                  v-model="isShow"
                  active-text="可见"
                  inactive-text="不可见">
                </el-switch>
              </el-row>
            </el-col>
          </el-row>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>
<script>
    import LeftMenu from '../../components/Menu.vue';
    import Top from '../../components/top.vue';
    // 导入组件 及 组件样式
    import { mavonEditor } from 'mavon-editor'
    import 'mavon-editor/dist/css/index.css'
    import util from "../../util";
    import {mapState} from "vuex";

    export default {
        name: 'Diary',
        components: {
            LeftMenu,
            Top,
            mavonEditor,
        },
        computed: {
            ...mapState({
                api: state => state.api,
            })
        },
        data () {
            return {
                blogTitle:'',
                blogContent:'',
                blogHtml:'',
                savedContent:'',
                tags: [],
                selectedTags: [],
                categoryData:[],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                isShow: true,
                isAddCategoryNow : false,
                parentCategory:'——父级分类名称——',
                categoryName:'',
                parentCategoryData:[],
            }
        },
        methods:{
            saveBlog(){
                console.log(this.selectedTags)
              //util.post(this.api+'/blog_editor')
            },
            dataChange(value,render){
              this.blogHtml = render;
            },
            showTags(){
                util.get(this.api+"blog/tags.json",{},(res)=>{
                    if(res.success){
                        this.tags = res.data.tags;
                        this.selectedTags = res.data.selectedTags;
                    }
                },this.getHeader());
            },
            showCategory(){
                util.get(this.api+"blog/category.json",{},(res)=>{
                    if(res.success){
                        this.categoryData = res.data.category;
                    }
                },this.getHeader());
                util.get(this.api+"category.json",{},(rst)=>{
                    if(rst.success){
                        this.parentCategoryData = rst.data.parent;
                    }else{
                        this.$message.error(rst.msg || '出错了噢~');
                    }
                },this.getHeader());
            },
            confirmAddCategory(){
                const data = {parent:this.parentCategory,name:this.categoryName};
                util.post(this.api+'/category_add.json',data,(res)=>{
                    if(res.success){
                        this.$message({
                            message: '创建成功',
                            type: 'success'
                        });
                        this.categoryName = '';
                        this.showCategory();
                    }else{
                        this.$message.error(res.msg || '出错了噢~');
                    }
                },this.getHeader());
            },
            getHeader() {
                return this.$cookies.get("iblog_user_auth");
            },
        },
        created() {
            this.showTags();
            this.showCategory();
        }
    }
</script>

<style>
  .main-content{
    padding-left: 20px;
  }
  .bg-purple{
    padding-right: 20px;
  }
  .bg-purple-light{
    padding-left: 20px;
  }
  .form-item{
    padding-bottom: 10px;
  }
  #blog-title{
    text-align: center;
    font-size:30px;
    margin-bottom: 20px;
    font-weight: bold;
    border: none;
  }
  .save-btn el-button{
    width: 50%;
  }
</style>
