@extends('layouts.app')

@section('content')
 <div class="row">
    <div class="col-md-3">
	 	<a href="{{ route('projects') }}"><button type="button" class="btn btn-info">Список проектов</button></a>
    </div>
    <div class="col-md-3">
    <a href="{{ route('project.create') }}"><button type="button" class="btn btn-info">Добавить проект</button></a>
    </div>
  </div>
    <br>

<div class="row">
	@if($projects->count()>0)
	<div class="col-md-4">
  	@if(count($errors)>0)
	<ul class="list-group">
		@foreach($errors->all() as $error)
			<li class="list-group-item text-danger">{{ $error }}</li>
		@endforeach
	</ul>
	@endif


	 <form action="{{ route('settings.update') }}" method="POST">
	 	{{ csrf_field() }}
	 	<div class="form-group">
	    <label for="title">Текущий проект</label>
	    <select class="form-control" name="project_id">
	    	<option value="">Нет</option>
	    	@foreach($projects as $project)
			@if($settings->project_id == $project->id)
				<option selected value="{{ $project->id }}">{{ $project->name }}</option>
			@else
				<option value="{{ $project->id }}">{{ $project->name }}</option>
			@endif
	    	@endforeach
	    </select>
		</div>
	    <div class="form-group">
	    <label for="vk_service_token">VK сервисный ключ</label>
	    <input class="form-control" type="text" name="vk_service_token" value="{{ $settings->vk_service_token }}">
		</div>
		<div class="form-group">
		    <label for="posts_amount">Количество записей с одного источника за раз</label>
		    <input class="form-control" type="text" name="posts_amount" value="{{ $settings->posts_amount }}">
		</div>	 

	  <button type="submit" class="btn btn-success">Сохранить</button>
	</form>



	</div>
	@else
		<div class="col-md-12">
		Необходимо добавить хотя бы один проект
	</div>
	@endif
  </div>

@stop

@section('main_scripts')
<script src="{{ asset('js/app.js') }}"></script>
@stop