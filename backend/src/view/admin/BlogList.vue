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
            <el-input style="width: 230px;" placeholder="搜索文章" prefix-icon="el-icon-search" v-model="query"></el-input>
            <el-cascader placeholder="选择分类" expand-trigger="hover" :options="categoryList" v-model="category"
              @change="handleChange" clearable>
            </el-cascader>

            <el-select v-model="user" placeholder="选择用户">
              <el-option v-for="item in userList" :key="item.id" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
            <el-button type="primary" icon="el-icon-search" @click="toShowList" :loading="searchLoading">搜索</el-button>
          </el-row>
          <template>
            <el-table :data="list" border style="width: 100%">
              <el-table-column prop="title" label="标题" width="400">
              </el-table-column>
              <el-table-column label="分类" width="180">
                <template slot-scope="scope">
                  <el-tag
                    v-for="item in scope.row.category"
                    :key="item"
                    :type="info"
                    effect="plain">
                    {{ item }}
                  </el-tag>
                </template>
              </el-table-column>
              <el-table-column prop="tags" label="标签" width="180">
              </el-table-column>
              <el-table-column prop="name" label="用户" width="180">
              </el-table-column>
              <el-table-column prop="modifyd_time" label="上次编辑时间" width="180">
              </el-table-column>
              <el-table-column prop="display" label="可见" width="100">
              </el-table-column>
              <el-table-column prop="is_push" label="发布" width="100">
              </el-table-column>
              <el-table-column fixed="right" label="操作">
                <template slot-scope="scope">
                  <el-button @click="viewBlog(scope.row)" type="text" size="small">查看</el-button>
                  <el-button @click="editBlog(scope.row)" type="text" size="small">编辑</el-button>
                  <el-button type="text" size="small">加入回收站</el-button>
                </template>
              </el-table-column>
            </el-table>
          </template>
           <div class="block" style="margin-top: 20px;text-align: center;">
              <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="page"
                :page-sizes="[10, 20, 30, 100]"
                :page-size="limit"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total">
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
  import util from "../../util";
  import {mapState} from "vuex";

  export default {
    name: 'AdminBlogAdd',
    components: {
      LeftMenu,
      Top
    },
    computed: {
        ...mapState({
            api: state => state.api,
        })
    },
    data() {
      return {
          list:[],
          query:'',
          category:'',
          user:'',
          page:1,
          limit:10,
          categoryList:[],
          userList:[],
          total:'',
          searchLoading:'false',
      }
    },
    methods:{
      getHeader() {
          return this.$cookies.get("iblog_user_auth");
      },
      showList(){
          let data = {};
          data.page = this.page;
          data.limit = this.limit;

          if(this.query!=''){
              data.query = this.query;
          }

          if(this.category != ''){
              data.category = this.category;
          }

          if(this.user != ''){
              data.user = this.user;
          }

          util.get(this.api + "blog/list.json", data, (res) => {
              if (res.success) {
                  this.list = res.data.blogList;
                  this.total = res.data.total;
                  this.categoryList = res.data.category;
                  this.userList = res.data.userList;
              }
              this.searchLoading = false;
          }, this.getHeader());
      },
      viewBlog(row){
        location.href = "/article?name="+row.title;
      },
      editBlog(row){
        location.href = "/adminBlogAdd?blog="+row.id;
      },
      toShowList(){
        this.searchLoading = true;
        this.page = 1;
        this.showList();
      },
      handleCurrentChange(page){
        this.page = page;
        this.showList();
      },
      handleSizeChange(size){
        this.limit = size;
        this.showList();
      },
      handleChange(e){
        if(e == undefined) return;
        this.category = e[e.length-1];
      }
    },
    created() {
        this.showList();
    }
  }
</script>

<style>

</style>
