<template>
  <div class="hello">
    <el-row>
      <Top></Top>
    </el-row>
    <el-row>
      <el-col :span="3">
        <LeftMenu></LeftMenu>
      </el-col>
      <el-col :span="21">
        <!--内容区域 -->
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
        radio: '1'
      }
    }
  }
</script>

<style>
</style>
