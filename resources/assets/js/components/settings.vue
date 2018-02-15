<template>
<div>

 <div class="row">
    <div class="col-md-3">
    <a href=""><button type="button" class="btn btn-info">Список проектов</button></a>
    </div>
    <div class="col-md-3">
    <a href=""><button type="button" class="btn btn-info">Добавить проект</button></a>
    </div>
  </div>
    <br>

<div class="row">

  <div class="col-md-4">



   <form v-on:submit.prevent="submitForm" method="POST">

    <div class="form-group">
      <label for="title">Текущий проект</label>
      <select v-on:change="setProject($event)" class="form-control" name="project_id">
        <option value="0">Нет</option>
        <option v-model="project.id" selected v-for="project in settings.projects" v-if="project.id == settings.project_id" v-bind:value="project.id">{{ project.name }}</option>
        <option v-model="project.id" v-else="" v-for="project in settings.projects" v-bind:value="project.id">{{ project.name }}</option>
      </select>
    </div>
      <div class="form-group">
      <label for="vk_service_token">VK сервисный ключ</label>
      <input class="form-control" type="text" name="vk_service_token" v-model="settings.vk_service_token">
    </div>
    <div class="form-group">
        <label for="posts_amount">Количество записей с одного источника за раз</label>
        <input class="form-control" type="text" name="posts_amount" v-model="settings.posts_amount">
    </div>   

    <button type="submit" class="btn btn-success">Сохранить</button>
  </form>



  </div>

  </div>
</div>
</template>

<script>
export default 
{
  data: function(){
    return {
      settings: {
        projects: [],
        vk_service_token: '',
        posts_amount: '',
        project_id: ''
      }
    }
  },
   created: function(){
       this.fetchItems();
   },
   methods: {
      fetchItems(){
        var app = this;
        this.axios.get('/api/settings').then(function(r){
        //console.log(r)
        if(r.data.success){
          app.settings.projects = r.data.response.projects;
          app.settings.vk_service_token = r.data.response.settings.vk_service_token;
          app.settings.posts_amount = r.data.response.settings.posts_amount;
          app.settings.project_id = r.data.response.settings.project_id;
        } else {
          console.log(r.data.error);
        }
        }).catch(function(e) {
          console.log(e);
        });
      },
      submitForm: function(){
        var app = this;
        //var toastr = toastr;
        this.axios.post('/api/settings/update', app.settings).then(function(r){
          if(r.data.success){
            toastr.success('Настройки обновлены');
          } else {
            toastr.error(r.data.error);
          }
        }).catch(function(e) {
          console.log(e);
        });
      },
      setProject: function(e){
        this.settings.project_id = parseInt(e.target.value);
      }
    }
  }
</script>