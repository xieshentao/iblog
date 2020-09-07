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
              <el-input v-model="title" id = 'blog-title' placeholder="“请输入标题”"></el-input>
              <Editor v-model="detail"></Editor>
            </el-col>
            <el-col :span="4">
              <el-row>
                <el-col :span="12"><el-button plain style="width: 90%">保存</el-button></el-col>
                <el-col :span="12"><el-button type="primary" style="width: 90%">发布</el-button></el-col>
              </el-row>
              <el-row>
               <h3>标签</h3>
                <el-select
                  v-model="value10"
                  multiple
                  filterable
                  allow-create
                  default-first-option
                  placeholder="请选择文章标签" style="width: 95%">
                  <el-option
                    v-for="item in options5"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                  </el-option>
                </el-select>
                <h3>分类</h3>
                <el-tree
                  :data="data2"
                  show-checkbox
                  node-key="id"
                  :default-expanded-keys="[2, 3]"
                  :default-checked-keys="[5]"
                  :props="defaultProps">
                </el-tree>
                <h3>可见</h3>
                <el-switch
                  v-model="value3"
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
                title:'',
                options5: [{
                    value: 'HTML',
                    label: 'HTML'
                }, {
                    value: 'CSS',
                    label: 'CSS'
                }, {
                    value: 'JavaScript',
                    label: 'JavaScript'
                }],
                value10: [],
                data2: [{
                    id: 1,
                    label: '一级 1',
                    children: [{
                        id: 4,
                        label: '二级 1-1',
                        children: [{
                            id: 9,
                            label: '三级 1-1-1'
                        }, {
                            id: 10,
                            label: '三级 1-1-2'
                        }]
                    }]
                }, {
                    id: 2,
                    label: '一级 2',
                    children: [{
                        id: 5,
                        label: '二级 2-1'
                    }, {
                        id: 6,
                        label: '二级 2-2'
                    }]
                }, {
                    id: 3,
                    label: '一级 3',
                    children: [{
                        id: 7,
                        label: '二级 3-1'
                    }, {
                        id: 8,
                        label: '二级 3-2'
                    }]
                }],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                value3: true,
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
    font-size:30px;
    margin-bottom: 20px;
    font-weight: bold;
    border: none;
  }
  .save-btn el-button{
    width: 50%;
  }
</style>
