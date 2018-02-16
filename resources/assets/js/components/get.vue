<template>
<div>

<div class="row" v-if="validated">
<div class="col-md-12">
<div class="panel panel-info">

  <div class="panel-heading">
    <h4>Полученные посты</h4>
  </div>

  <div class="panel-body">

  <table class="table table-hover">

    <thead>
    <th style='width:35%'></th>
    <th style='width:40%'></th>
    <th style='width:25%'></th>
    </thead>

    <tbody>

      <tr v-for="post in posts" v-bind:class="post.post_id">
        <td><img v-bind:src="post.thumb" style="width:200px"></td>
        <td><textarea v-model="post.text" class="form-control" rows="7">{{ post.text }}</textarea></td>
        <td><button v-on:click="savePost(post.post_id)" class="btn btn-block btn-success">Сохранить</button></td>
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
        posts: [],
        validated: false
    }
  },
   created: function(){
    if(this.$root.projectSettings.project_id != 0){
      this.validated = true;
      this.fetchItems();
    } else {
      toastr.error('Необходимо сохранить проект в настройках');
      return;
    }
   },
   methods: {
      fetchItems(){
        var app = this;
        this.axios.get('/api/get').then(function(r){
        if(r.data.success){
          app.posts = r.data.response.posts;
        } else {
          toastr.error(r.data.error);
        }
        }).catch(function(e) {
          console.log(e);
        });
      },
      savePost(id){
        this.axios.post('/api/postSave', this.posts[id]).then(function(r){
        if(r.data.success){
          $('.'+id).remove();
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