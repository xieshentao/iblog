<template>
  <div>
    <input v-model="email">
    <input v-model="pwd">
    <button v-on:click="doLogin">登陆</button>
  </div>

</template>

<script>
    import {mapState} from "vuex";
    import util from "@/util";

    export default {
        name: "Login",
        data(){
            return{
                email:'',
                pwd:'',
            }
        },
        computed:{
            ...mapState({
                api: state => state.api,
            })
        },
        methods:{
            doLogin(){
                let email = this.email;
                let pwd = this.pwd;
                util.post(this.api+"login",{email:email,pwd:pwd},(rst)=> {
                    if(rst.success){
                        this.$cookies.set('iblog_user_auth', rst.data,7*24*3600);
                        this.$message({
                            message: '登陆成功！',
                            type: 'success'
                        });
                        location.href = '/admin';
                    }else{
                        this.$message.error(rst.msg || '出错了~');
                    }
                },0)
            },
        },
    }
</script>

<style scoped>

</style>
