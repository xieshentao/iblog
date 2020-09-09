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
        <el-row class="">
          <!-- 分类-->
          <el-col :span="12">
            <h3>分类</h3>
            <div class="grid-content bg-purple">
              <el-row>
              <el-form ref="form" label-width="80px">
                <el-form-item label="父类">
                  <el-select v-model="parentCategory" placeholder="——父级分类名称——">
                    <el-option
                      v-for="item in parentCategoryData"
                      :key="item"
                      :label="item"
                      :value="item">
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="名称">
                  <el-input v-model="categoryName" style="width:120px"></el-input>
                  <el-button type="primary" @click="saveCategory">立即创建</el-button>
                </el-form-item>
              </el-form>
              </el-row>
              <!--所有分类-->
              <el-row class="type-box">
                <el-table
                  height="500"
                  v-loading="loading"
                  :data="categoryData"
                  style="width: 100%">
                  <el-table-column
                    fixed
                    prop="name"
                    label="父分类"
                    style="width: 30%">
                  </el-table-column>
                  <el-table-column
                    fixed
                    prop="childName"
                    label="子分类"
                    style="width: 30%">
                  </el-table-column>
                  <el-table-column
                    prop="articleCount"
                    label="文章数"
                    style="width: 10%">
                  </el-table-column>
                  <el-table-column
                    fixed="right"
                    label="操作"
                    style="width: 30%">
                    <template slot-scope="scope">
                      <el-button @click="delCategory(scope.row)" type="text" size="small">删除</el-button>
                      <el-button type="text" size="small">编辑</el-button>
                    </template>
                  </el-table-column>
                </el-table>
              </el-row>
            </div>
          </el-col>
          <!-- 标签-->
          <el-col :span="12">
            <h3>标签</h3>
            <div class="grid-content bg-purple-light">
               <el-tag
                 class="tag"
                 :key="tag.name"
                 v-for="tag in dynamicTags"
                 closable
                 :disable-transitions="false"
                 @close="handleClose(tag)">
                 {{tag.name}}
               </el-tag>
               <el-input
                 class="input-new-tag"
                 v-if="inputTagVisible"
                 v-model="inputTagValue"
                 ref="saveTagInput"
                 size="small"
                 @keyup.enter.native="handleInputConfirm"
                 @blur="handleInputConfirm"
               >
               </el-input>
               <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
            </div>
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
  import {mapState} from "vuex";
  import util from "@/util";

  export default {
    name: 'AdminIndex',
    components: {
      LeftMenu,
      Top
    },
    data () {
      return {
        loading:true,
        categoryData:[],
        parentCategory:'——父级分类名称——',
        categoryName:'',
        parentCategoryData:[],
        dynamicTags: [],
        inputTagVisible: false,
        inputTagValue: '',
      }
    },
    computed: {
      ...mapState({
        api: state => state.api,
      })
    },
    methods: {
      saveCategory(){
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
      showCategory(){
        util.get(this.api+"category.json",{},(rst)=>{
            if(rst.success){
                this.parentCategoryData = rst.data.parent;
                this.categoryData = rst.data.categoryData;
            }else{
                this.$message.error(rst.msg || '出错了噢~');
            }
            this.loading = false;
        },this.getHeader());
      },
      delCategory(row){
        util.post(this.api+"category_remove.json",{category_id:row.id},(rst)=>{
            if(rst.success){
                this.showCategory();
            }else{
                this.$message.error(rst.msg || '出错了噢~');
            }
        },this.getHeader());
      },
      handleClose(tag) {
        this.delLabel(tag);
      },
      getHeader() {
          return this.$cookies.get("iblog_user_auth");
      },
      showInput() {
        this.inputTagVisible = true;
        this.$nextTick(_ => {
          this.$refs.saveTagInput.$refs.input.focus();
        });
      },

      handleInputConfirm() {
        let inputTagValue = this.inputTagValue;
        this.addLabel(inputTagValue);
        this.inputTagVisible = false;
        this.inputTagValue = '';
      },
      showLabel(){
        util.get(this.api+"label.json",{},(rst)=>{
          if(rst.success){
              this.dynamicTags = rst.data.label;
          }else{
              this.$message.error(rst.msg || '出错了噢~');
          }
        },this.getHeader());
      },
      addLabel(label){
         let Label = {name:label};
         util.post(this.api+"label_add.json",{label_name:label},(rst)=>{
              if(rst.success){
                  this.dynamicTags.push(Label);
              }else{
                  this.$message.error(rst.msg || '出错了噢~');
              }
         },this.getHeader());
      },
      delLabel(tag){
          util.post(this.api+"label_remove.json",tag,(rst)=>{
              if(rst.success){
                  this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
              }else{
                  this.$message.error(rst.msg || '出错了噢~');
              }
          },this.getHeader());
      }
    },
    created(){
      this.showLabel();
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

  .el-tag + .el-tag {
    margin: 10px;
  }
  .button-new-tag {
    margin: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
  }
  .input-new-tag {
    width: 90px;
    margin: 10px;
    vertical-align: bottom;
  }

  .type-box{
    margin-left: 30px;
    border-top:1px solid #e0e0e0;
  }
</style>
