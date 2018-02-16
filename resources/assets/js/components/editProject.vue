<template>
<div>

   <div class="row">
    <div class="col-md-3">
      <router-link :to="{name: 'projects'}" class="btn btn-info">Список проектов</router-link>
    </div>
    <div class="col-md-3">
      <router-link :to="{name: 'addProject'}" class="btn btn-info">Добавить проект</router-link>
    </div>
  </div>
    <br>

    <div class="row">
      <div class="col-md-12">
<div class="panel panel-info">

  <div class="panel-heading">
    <h4>Редатировать проект</h4>
  </div>

  <div class="panel-body">

 <form v-on:submit.prevent="submitForm" method="POST">
    <div class="form-group">
      <label for="login">Название</label>
      <input type="text" class="form-control" v-model="project.name">
    </div>
    <div class="form-group">
      <label for="login">Инстаграмм логин</label>
      <input type="text" class="form-control" v-model="project.login">
    </div>
    <div class="form-group">
      <label for="password">Инстаграмм пароль</label>
      <input type="password" class="form-control" v-model="project.password">
    </div>
    <div class="form-group">
      <label for="feed">Источники контента (паблики VK)</label>
      <textarea id="feed" class="form-control" rows="1" v-model="project.feed"></textarea>
    </div>
    <div class="form-group">
      <label for="tags">Список тегов для поста</label>
      <textarea id="tags" class="form-control" rows="1" v-model="project.tags"></textarea>
    </div>

    <button type="submit" class="btn btn-success btn-block">Сохранить </button>
  

  </form>

</div></div></div></div></div>
</template>

<script>
export default 
{
  data: function(){
    return {
        project: {},
    }
  },
   created: function(){
    this.fetchItem();
   },
   methods: {
     fetchItem: function(){
       var app = this;
       this.axios.get('/api/project/'+this.$route.params.id, this.project).then(function(r){
          if(r.data.success){
            app.project = r.data.response.project;
            app.project.feed = r.data.response.feed;
            app.project.tags = r.data.response.tags;
          } else {
            toastr.error(r.data.error);
          }
        }).catch(function(e) {
          console.log(e);
        });
     },
      submitForm: function(){
        var app = this;
        this.axios.post('/api/project/update/'+this.$route.params.id, this.project).then(function(r){
          if(r.data.success){
            toastr.success('Проект обновлен');
            app.$router.push('/panel/projects');
          } else {
            toastr.error(r.data.error);
          }
        }).catch(function(e) {
          console.log(e);
        });
      },
      setProject: function(e){
        this.settings.project_id = parseInt(e.target.value);
      },
      setMsg: function(msg){
        toastr.success(msg);
      }
    }
  }
</script>