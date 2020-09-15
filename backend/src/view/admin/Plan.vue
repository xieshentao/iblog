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
        <el-calendar>
          <!-- 这里使用的是 2.5 slot 语法，对于新项目请使用 2.6 slot 语法-->
          <template
            slot="dateCell"
            slot-scope="{date, data}">
            <p :class="data.isSelected ? 'is-selected' : ''">
              {{ data.day.split('-').slice(1).join('-') }}
            </p>
            <p style="font-size: 10px;">你好{{ '✔️'}}</p>
          </template>
        </el-calendar>
      </el-col>
    </el-row>
  </div>
</template>
<script>
    import LeftMenu from '../../components/Menu.vue';
    import Top from '../../components/top.vue';
    export default {
        name: 'AdminBlogAdd',
        components: {
            LeftMenu,
            Top
        },
        data () {
            return {
            }
        }
    }
</script>

 <style>
          .is-selected {
            color: #1989FA;
          }
</style>
