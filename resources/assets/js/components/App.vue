// App.vue

<template>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                 <router-link :to="{name: 'homePanel'}" class="btn btn-block btn-lg btn-info">Статистика</router-link>
                </div>

                <div class="panel-body">


                <div class="row">

                    <div class="col-md-4">
                        <router-link :to="{name: 'settings'}" class="btn btn-block btn-lg btn-info">Настройки</router-link>
                    </div>

                    <div class="col-md-4">
                    <router-link :to="{name: 'get'}" class="btn btn-block btn-lg btn-info">Получение</router-link>

                    </div>

                     <div class="col-md-4">
                          <a style='text-decoration:none' v-on:click="sendPost"><button type="button" class="btn btn-block btn-lg btn-info">Постинг</button></a>
                    </div>
                </div>
<br>

<transition name="fade">
    <router-view :key="$route.fullPath"></router-view>
</transition>

</div>
</div>
</div>
</div>
</template>

<style>
    .fade-enter-active, .fade-leave-active {
      transition: opacity 0.25s
    }
    .fade-enter, .fade-leave-active {
      opacity: 0
    }
</style>

<script>
    export default{
        data: function(){
            return {
                projectSettings: {
                    project_id: 0,
                    vk_service_token: ''
                }
                
            }
        },
        created: function(){
           this.goHomePanel();
        },
       methods: {
             goHomePanel: function(){
                this.$router.replace('/panel');
          },
          sendPost: function(){

            this.axios.get('/api/post').then(function(r){

            if(r.data.success){
              toastr.success('Пост отправлен в Инстаграм');
            } else {
              toastr.error(r.data.error);
            }
            }).catch(function(e) {
              console.log(e);
            });
          }
       }
    }
</script>