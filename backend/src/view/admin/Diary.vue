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
          <!-- 新增日记-->
          <el-col :span="12">
            <div class="grid-content bg-purple">
              <el-form ref="form" :model="form" label-width="80px" >
                 <el-input v-model="form.title" placeholder="标题" clearable class="form-item"></el-input>
                 <el-input
                   type="textarea"
                   :autosize="{ minRows: 15, maxRows: 30}"
                   placeholder="日记内容"
                   v-model="form.content"
                   class="foem-item"
                   >
                 </el-input>
              </el-form>
            </div>
          </el-col>
          <!-- 查看日记-->
          <el-col :span="12">
            <div class="grid-content bg-purple-light">
              <el-table
                    :data="tableData"
                    style="width: 100%">
                    <el-table-column
                      prop="date"
                      label="日期"
                      width="160">
                    </el-table-column>
                    <el-table-column
                      prop="name"
                      label="标题"
                      width="180">
                    </el-table-column>
                    <el-table-column
                      prop="address"
                      label="内容">
                    </el-table-column>
                    <el-table-column
                      prop="name"
                      label="操作"
                      width="160">
                    </el-table-column>
              </el-table>
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
    name: 'Diary',
    components: {
      LeftMenu,
      Top
    },
    data () {
      return {
        form:{
          title:'标题',
          content:'  ',
        }
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
</style>
