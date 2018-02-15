<template>
<div>
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#addProject">Добавить проект</button>

<div class="modal fade" id="addProject" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
 <form v-on:submit.prevent="submitForm" method="POST">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" 
          data-dismiss="modal" 
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" 
        id="favoritesModalLabel">Добавить проект</h4>
      </div>
      <div class="modal-body">
    <div class="form-group">
      <label for="name">Название</label>
      <input type="text" name="name" class="form-control" v-model="project.name">
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
  
      </div>

      <div class="modal-footer">

          <button type="submit" class="btn btn-success btn-block">Добавить</button>

      </div>
    </div>
  </div>
  </form>
</div>
</div>
</template>

<script>
export default 
{
  props: ['id'],
  data: function(){
    return {
        project: {
          name: '',
          login: '',
          password: '',
          feed: '',
          tags: ''
        },

    }
  },
   created: function(){
   },
   methods: {
      submitForm: function(){
        var app = this;
        this.axios.post('/api/project/store', this.project).then(function(r){
          if(r.data.success){
            toastr.success('Проект добавлен');
            $('#addProject').modal('hide')
            app.$router.push('/panel') 
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