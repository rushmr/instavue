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
      <div class="col-md-8">
<div class="panel panel-info">

  <div class="panel-heading">
    <h4>Проекты</h4>
  </div>

  <div class="panel-body">



  <table class="table table-hover">


    <tbody>

      <tr v-for="project in projects">
        <td>{{ project.name }}</td>
        <router-link :to="{name: 'editProject', params: {id: project.id}}" class="btn btn-info">Редактировать</router-link>
        <td><a onclick="return confirm('Уверены?');" class="btn btn-xs btn-danger" v-on:click="deleteProject(project.id)">Удалить</a></td>
      </tr>

    </tbody>
  </table>

</div>
</div>
</div>
</div>



</div>
</template>

<script>
export default 
{

  data: function(){
    return {
        projects: [],

    }
  },
   created: function(){
    this.fetchItems();
   },
   methods: {
      fetchItems(){
        var app = this;
        this.axios.get('/api/projects').then(function(r){
        if(r.data.success){
          app.projects = r.data.response.projects;
        } else {
          console.log(r.data.error);
        }
        }).catch(function(e) {
          console.log(e);
        });
      },
      deleteProject(id){
        var app = this;
        this.axios.get('/api/project/delete/'+id).then(function(r){
        if(r.data.success){
          var items = [{id: id}];
          app.projects.splice(_.indexOf(items, _.find(items, function (item) { return item.Id === 2; })), 1)
          toastr.success('Проект удален');
        } else {
          console.log(r.data.error);
        }
        }).catch(function(e) {
          console.log(e);
        });
      }
    }
  }
</script>