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
              <el-input v-model="title" id = 'blog-title' placeholder="请输入标题"></el-input>
              <Editor></Editor>
            </el-col>
            <el-col :span="4">
              分类|标签|可见
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
    import Editor from "../../components/Editor";
    export default {
        name: 'Diary',
        components: {
            LeftMenu,
            Top,
            Editor
        },
        data () {
            return {
                title:''
            }
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
    font-size:20px;
    margin-bottom: 20px;
    font-weight: bold;
  }
</style>
