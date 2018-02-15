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
                        <a style='text-decoration:none' href=""><button type="button" class="btn btn-block btn-lg btn-info">Получение</button></a>
                    </div>

                     <div class="col-md-4">
                          <a style='text-decoration:none' href=""><button type="button" class="btn btn-block btn-lg btn-info">Постинг</button></a>
                    </div>
                </div>
<br>

<transition name="fade">
    <router-view></router-view>
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
        created: function(){
           //this.goHomePanel();
        },
       methods: {
             goHomePanel: function(){
                this.$router.replace('/panel');
          },
       }
    }
</script>