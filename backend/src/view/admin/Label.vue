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

            </div>
          </el-col>
          <!-- 标签-->
          <el-col :span="12">
            <h3>标签</h3>
            <div class="grid-content bg-purple-light">
               <el-tag
                 class="tag"
                 :key="tag"
                 v-for="tag in dynamicTags"
                 closable
                 :disable-transitions="false"
                 @close="handleClose(tag)">
                 {{tag}}
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
  export default {
    name: 'AdminIndex',
    components: {
      LeftMenu,
      Top
    },
    data () {
      return {
        form:{
          title:'标题',
          content:'  ',
        },
        dynamicTags: ['标签一', '标签二', '标签三'],
        inputTagVisible: false,
        inputTagTValue: ''
      }
    },
    methods: {
      handleClose(tag) {
        this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
      },

      showInput() {
        this.inputTagVisible = true;
        this.$nextTick(_ => {
          this.$refs.saveTagInput.$refs.input.focus();
        });
      },

      handleInputConfirm() {
        let inputTagValue = this.inputTagValue;
        if (inputTagValue) {
          this.dynamicTags.push(inputTagValue);
        }
        this.inputTagVisible = false;
        this.inputTagValue = '';
      }
    }
  }
</script>

<style>
  .main-content{
    padding: 20px;
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
</style>
