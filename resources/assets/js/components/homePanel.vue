<template>
<div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info text-center">
            <div class="panel-heading"><h4>Текущий проект</h4></div>

            <div class="panel-body">
               {{ project }}
            </div>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading"><h4>Запланировано постов</h4></div>

                <div class="panel-body">
                    {{ futuredPosts }}
                </div>
            </div>
        </div>

  <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading"><h4>Опубликовано постов</h4></div>

                <div class="panel-body">
                   {{ executedPosts }}
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
  		futuredPosts: 'нет',
      executedPosts: '0',
      project: '0'
  	}
  },
   created: function(){
       this.fetchItems();
   },
   methods: {
      testm: function(){
        this.fetchItems();
      },
      fetchItems(){
        var app = this;
        this.axios.get('/api/homePanel').then(function(r){
        //console.log(r);
        if(r.data.success){
          app.futuredPosts = r.data.response.futuredPosts;
          app.executedPosts = r.data.response.executedPosts;
          app.project = r.data.response.project;
        } else {
          console.log(r.data.error);
        }
        }).catch(function(e) {
          console.log(e);
        });
      },
    }
  }
</script>