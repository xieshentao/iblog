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
          <el-row style="margin-bottom: 20px;display: block;" class="demo-input-suffix">
            <el-input style="width: 230px;" placeholder="搜索文章" prefix-icon="el-icon-search" v-model="input21"></el-input>
            <el-cascader placeholder="选择分类" expand-trigger="hover" :options="options" v-model="selectedOptions2"
              @change="handleChange">
            </el-cascader>

            <el-select v-model="value" placeholder="选择用户">
              <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
              </el-option>
            </el-select>
            <el-button type="primary" icon="el-icon-search">搜索</el-button>
          </el-row>
          <template>
            <el-table :data="tableData" border style="width: 100%">
              <el-table-column prop="date" label="标题" width="400">
              </el-table-column>
              <el-table-column prop="date" label="分类" width="180">
              </el-table-column>
              <el-table-column prop="date" label="标签" width="180">
              </el-table-column>
              <el-table-column prop="name" label="用户" width="180">
              </el-table-column>
              <el-table-column prop="address" label="可见" width="100">
              </el-table-column>
              <el-table-column prop="address" label="发布" width="100">
              </el-table-column>
              <el-table-column fixed="right" label="操作">
                <template slot-scope="scope">
                  <el-button @click="handleClick(scope.row)" type="text" size="small">查看</el-button>
                  <el-button type="text" size="small">编辑</el-button>
                  <el-button type="text" size="small">加入回收站</el-button>
                </template>
              </el-table-column>
            </el-table>
          </template>
           <div class="block" style="margin-top: 20px;text-align: center;">
              <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="currentPage4"
                :page-sizes="[15, 30, 45, 60]"
                :page-size="15"
                layout="total, sizes, prev, pager, next, jumper"
                :total="400">
              </el-pagination>
            </div>
        </el-card>

        <!--内容区域 -->
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
    data() {
      return {}
    }
  }
</script>

<style>

</style>
