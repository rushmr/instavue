$('a.addpost').on('click', function(){

	var row = $(this).parent().parent();

	var postId = $(this).attr('data-post-id');
	var text = row.find('.text').val();
	var picture_path = row.find('.picture').attr('href');
	//var token = $('meta[name="csrf-token"]').attr('content');

	//console.log('post_id='+postId+'&picture_path='+picture_path+'&text='+text+'&_token='+token);

	$.ajax({
	  url: '/api/postSave',
	  method: 'post',
	  data: 'post_id='+postId+'&picture_path='+picture_path+'&text='+text,
	  success: function(data){
	  	if(data.success == 1){
	  		row.hide();
	  	} else {
	  		console.log(data.error);
	  	}
	  }
	});

});